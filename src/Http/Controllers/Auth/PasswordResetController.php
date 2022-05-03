<?php

namespace Laraflow\Laraflow\Http\Controllers\Auth;

use App\Http\Requests\Auth\NewPasswordRequest;
use App\Http\Requests\Auth\PasswordResetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Laraflow\Laraflow\Services\Auth\PasswordResetService;

class PasswordResetController extends Controller
{
    /**
     * @var PasswordResetService
     */
    private $passwordResetService;

    /**
     * @param PasswordResetService $passwordResetService
     */
    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Display the password reset link request view.
     *
     */
    public function create()
    {
        return view('laraflow::auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param PasswordResetRequest $request
     * @return RedirectResponse
     */
    public function store(PasswordResetRequest $request): RedirectResponse
    {
        $inputs = $request->only('email', 'mobile', 'username');

        $confirm = $this->passwordResetService->createPasswordResetToken($inputs);

        if ($confirm['status'] === true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->to(route('auth.password.reset', $confirm['token']));
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back();
    }

    public function edit($token)
    {
        return view('laraflow::auth.reset-password', ['token' => $token]);
    }

    public function update(NewPasswordRequest $request)
    {
        $inputs = $request->only('email', 'mobile', 'username', 'password', 'password_confirmation', 'token');

        $confirm = $this->passwordResetService->updatePassword($inputs);

        if ($confirm['status'] === true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->to(route('auth.login'));
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back();
    }
}
