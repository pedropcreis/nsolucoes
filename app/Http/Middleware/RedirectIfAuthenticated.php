<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // $guards = empty($guards) ? [null] : $guards;
        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            // dd(Auth::user());
            if(Auth::user()->user_type == 'F' || Auth::user()->user_type == 'A') {
                return redirect('/dashboard');
            } else {
                return redirect('/');
            }
        }
        return $next($request);
    }
}
