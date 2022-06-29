<?php

namespace Laraflow\Core\Http\Controllers\Auth;

use App\Http\Requests\Auth\NewPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Laraflow\Core\Services\Auth\NewPasswordService;

class NewPasswordController extends Controller
{
    /**
     * @var NewPasswordService
     */
    private $newPasswordService;

    /**
     * @param NewPasswordService $newPasswordService
     */
    public function __construct(NewPasswordService $newPasswordService)
    {
        $this->newPasswordService = $newPasswordService;
    }

    /**
     * Display the password reset view.
     *
     * @param Request $request
     * @return View
     */
    public function create(Request $request): View
    {
    }

    /**
     * Handle an incoming new password request.
     *
     * @param NewPasswordRequest $request
     * @return void
     */
    public function store(NewPasswordRequest $request)
    {
    }
}
