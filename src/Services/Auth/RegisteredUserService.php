<?php

namespace Laraflow\Laraflow\Services\Auth;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laraflow\Laraflow\Repositories\Eloquent\Auth\UserRepository;
use Laraflow\Laraflow\Services\Utilities\FileUploadService;
use Laraflow\Laraflow\Services\Utilities\UtilityService;
use Laraflow\Laraflow\Supports\Constant;

class RegisteredUserService
{
    /**
     * @var UserRepository
     */
    public $userRepository;

    /**
     * @var FileUploadService
     */
    public $fileUploadService;

    private $user;

    /**
     * RegisteredUserService constructor.
     * @param UserRepository $userRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(
        UserRepository $userRepository,
        FileUploadService $fileUploadService
    )
    {
        $modelPath = config('triplea.user');
        if (is_string($modelPath)) {
            $this->user = new $modelPath();
        }

        $this->userRepository = $userRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param array $registerFormInputs
     * @return array
     * @throws Exception
     */
    public function attemptRegistration(array $registerFormInputs): ?array
    {
        DB::beginTransaction();
        //format request object
        $inputs = $this->formatRegistrationInfo($registerFormInputs);
        try {
            //create new user
            $newUser = $this->userRepository->create($inputs);
            if ($newUser instanceof $this->user) {
                if ($this->attachAvatarImage($newUser) && $this->attachDefaultRoles($newUser)) {
                    DB::commit();
                    $newUser->refresh();

                    Auth::login($newUser);

                    return ['status' => true, 'message' => __('auth.register.success'), 'level' => Constant::MSG_TOASTR_SUCCESS, 'title' => 'Authentication'];
                } else {
                    return ['status' => false, 'message' => __('auth.register.failed'), 'level' => Constant::MSG_TOASTR_WARNING, 'title' => 'Alert!'];
                }
            } else {
                return ['status' => false, 'message' => 'User model creation failed', 'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Error!'];
            }
        } catch (\Exception $exception) {
            $this->userRepository->handleException($exception);
            return ['status' => false, 'message' => __($exception->getMessage()), 'level' => Constant::MSG_TOASTR_ERROR, 'title' => 'Error!'];
        }
    }

    /**
     * @param array $request
     * @return array
     * @throws Exception
     */
    private function formatRegistrationInfo(array $request): array
    {
        //Hash password
        return [
            'name' => $request['name'],
            'password' => UtilityService::hashPassword(($request['password'] ?? Constant::PASSWORD)),
            'username' => ($request['username'] ?? UtilityService::generateUsername($request['name'])),
            'mobile' => ($request['mobile'] ?? null),
            'email' => ($request['email'] ?? null),
            'remarks' => 'self-registered',
            'enabled' => Constant::ENABLED_OPTION
        ];
    }


    /**
     * @param Model $user
     * @return bool
     * @throws Exception
     */
    protected function attachAvatarImage($user): bool
    {
        //add profile image
        $profileImagePath = $this->fileUploadService->createAvatarImageFromText($user->name);
        $user->addMedia($profileImagePath)->toMediaCollection('avatars');
        return $user->save();
    }

    /**
     * @param Model $user
     * @return bool
     */
    protected function attachDefaultRoles($user): bool
    {
        $this->userRepository->setModel($user);
        return $this->userRepository->manageRoles([Constant::GUEST_ROLE_ID]);
    }
}
