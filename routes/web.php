<?php

use App\Http\Controllers\Auth\PasswordResetController;
use Illuminate\Support\Facades\Route;
use Laraflow\Laraflow\Http\Controllers\Auth\AuthenticatedSessionController;
use Laraflow\Laraflow\Http\Controllers\Auth\ConfirmablePasswordController;
use Laraflow\Laraflow\Http\Controllers\Auth\EmailVerificationNotificationController;
use Laraflow\Laraflow\Http\Controllers\Auth\EmailVerificationPromptController;
use Laraflow\Laraflow\Http\Controllers\Auth\RegisteredUserController;
use Laraflow\Laraflow\Http\Controllers\Auth\VerifyEmailController;

/*
 |--------------------------------------------------------------------------
 | Web Routes
 |--------------------------------------------------------------------------
 |
 | Here is where you can register web routes for your application. These
 | routes are loaded by the RouteServiceProvider within a group which
 | contains the "web" middleware group. Now create something great!
 |
 */

Route::get('/', function () {
    return redirect()->to('backend/login');
})->name('home');

/**
 * Authentication Route
 */
Route::prefix(config('laraflow.auth.prefix'))->name('backend.auth.')->group(function () {

    Route::view('/privacy-terms', 'auth::terms')
        ->name('terms');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->middleware('guest')
        ->name('login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest');

    if (config('laraflow.auth.allow_register')):
        Route::get('/register', [RegisteredUserController::class, 'create'])
            ->middleware('guest')
            ->name('register');

        Route::post('/register', [RegisteredUserController::class, 'store'])
            ->middleware('guest');
    endif;

    if (config('laraflow.auth.allow_password_reset')):
        Route::get('/forgot-password', [PasswordResetController::class, 'create'])
            ->middleware('guest')
            ->name('password.request');
    endif;

    Route::post('/forgot-password', [PasswordResetController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])
        ->middleware('guest')
        ->name('password.reset');

    Route::post('/reset-password', [PasswordResetController::class, 'update'])
        ->middleware('guest')
        ->name('password.update');

    Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->middleware('auth')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['auth', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->middleware('auth')
        ->name('password.confirm');

    Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware('auth');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth')
        ->name('logout');
});

/*Route::group(function () {

    Route::middleware(['auth'])->name('backend.')->group(function () {
        Route::prefix('settings')->name('settings.')->group(function () {
            //User
            Route::prefix('users')->name('users.')->group(function () {
                Route::patch('{user}/restore', [UserController::class, 'restore'])->name('restore');
                Route::get('export', [UserController::class, 'export'])->name('export');
            });
            Route::resource('users', UserController::class)->where(['user' => '([0-9]+)']);

            //Permission
            Route::prefix('permissions')->name('permissions.')->group(function () {
                Route::patch('{permission}/restore', [PermissionController::class, 'restore'])->name('restore');
                Route::get('/export', [PermissionController::class, 'export'])->name('export');
            });
            Route::resource('permissions', PermissionController::class)->where(['permission' => '([0-9]+)']);

            //Role
            Route::prefix('roles')->name('roles.')->group(function () {
                Route::patch('{role}/restore', [RoleController::class, 'restore'])->name('restore');
                Route::put('{role}/permission', [RoleController::class, 'permission'])
                    ->name('permission')->where(['role' => '([0-9]+)']);
                Route::get('export', [RoleController::class, 'export'])->name('export');
                Route::get('ajax', [RoleController::class, 'ajax'])->name('ajax')->middleware('ajax');
            });
            Route::resource('roles', RoleController::class)->where(['role' => '([0-9]+)']);

        });
    });

});*/
