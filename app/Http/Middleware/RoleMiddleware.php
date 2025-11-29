<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user_check = Auth::check();

        if (!$user_check) {
            return Redirect::route('showLogin')->with('error', 'Harus login terlebih dahulu.');
        }

        $role = Auth::user()->role;
        if (!in_array($role, $roles)) {
            return back()->withErrors('Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
