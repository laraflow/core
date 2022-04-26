<?php

namespace Laraflow\Laraflow\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

/**
 * Ajax Request Middleware
 *
 * Class VerifyAjax
 * @package Laraflow\Laraflow\Middleware
 */
class VerifyAjax
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax()) {
            return $next($request);
        }

        throw new UnauthorizedException('Direct Route Call is prohibited');
    }
}
