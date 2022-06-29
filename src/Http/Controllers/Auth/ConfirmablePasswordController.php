<?php

namespace Laraflow\Core\Http\Controllers\Auth;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     *
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('laraflow::auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if (! guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        $request->session()->put('auth.password_confirmed_at', time());

        return redirect()->back();
    }
}
