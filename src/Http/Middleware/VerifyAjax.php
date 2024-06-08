<?php

namespace Laraflow\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

/**
 * Ajax Request Middleware
 *
 * Class VerifyAjax
 */
class VerifyAjax
{
    /**
     * Handle an incoming request.
     *
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
