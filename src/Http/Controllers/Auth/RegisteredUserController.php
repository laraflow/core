<?php

namespace Laraflow\Laraflow\Http\Controllers\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Laraflow\LaraFlow\Http\Requests\Auth\RegisterRequest;
use Laraflow\Laraflow\Services\Auth\RegisteredUserService;

class RegisteredUserController extends Controller
{
    /**
     * @var RegisteredUserService
     */
    private $registeredUserService;

    /**
     * RegisteredUserController constructor.
     * @param RegisteredUserService $registeredUserService
     */
    public function __construct(RegisteredUserService $registeredUserService)
    {
        $this->registeredUserService = $registeredUserService;
    }

    /**
     * Display the registration view.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('laraflow::auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param RegisterRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $confirm = $this->registeredUserService->attemptRegistration($inputs);

        if ($confirm['status'] == true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route(config('backend.config.home_url', 'admin.'));
        } else {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->back();
        }
    }
}
