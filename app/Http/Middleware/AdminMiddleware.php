<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\AdminController;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // $user = auth()->user();
        // $isAdmin = $user->hasRole('Admin');

        // // Debugging output
        // dd($user->roles, $isAdmin);

        if (auth()->check() && auth()->user()->hasRole('Admin')) {
            return $next($request);
        }

        return redirect('/');
    }
}
