<?php

namespace Laraflow\Core\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laraflow\Core\Http\Requests\Auth\LoginRequest;
use Laraflow\Core\Services\Auth\AuthenticatedSessionService;

/**
 * Class AuthenticatedSessionController
 * @package Laraflow\Core\Http\Controllers\Auth
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * @var AuthenticatedSessionService
     */
    private $authenticatedSessionService;

    /**
     * @param AuthenticatedSessionService $authenticatedSessionService
     */
    public function __construct(AuthenticatedSessionService $authenticatedSessionService)
    {
        $this->authenticatedSessionService = $authenticatedSessionService;
    }

    /**
     * Display the login view.
     *
     * @return View
     */
    public function create(): View
    {
        return view('laraflow::auth.login');
    }

    /**
     * Handle an incoming login request.
     *
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $confirm = $this->authenticatedSessionService->attemptLogin($request);

        if ($confirm['status'] === true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->route($confirm['landing_page']);
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back();
    }

    /**
     * Destroy an authenticated session
     * Handing logout request
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $confirm = $this->authenticatedSessionService->attemptLogout($request);
        if ($confirm['status'] === true) {
            notify($confirm['message'], $confirm['level'], $confirm['title']);
            return redirect()->to(route('home'));
        }

        notify($confirm['message'], $confirm['level'], $confirm['title']);
        return redirect()->back();
    }
}
