<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($role === 'admin' && $user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'guru' && $user->role !== 'guru') {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'siswa' && $user->role !== 'siswa') {
            abort(403, 'Unauthorized action.');
        }

        if ($role === 'orangtua' && $user->role !== 'orangtua') {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}