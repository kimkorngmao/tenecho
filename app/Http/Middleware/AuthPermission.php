<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $permission = $request->route()->getName();

        if (!$user) {
            return redirect('/login');
        }

        if(!$user->hasPermission($permission)){
            abort(403);
        }

        return $next($request);
    }
}
