<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role == "2" || Auth::user()->role == "3" || Auth::user()->status == 0 || Auth::user()->status == 2) {
            Session::flash('error', 'Không đủ thẩm quyền');
            return redirect()->route('login');
        }
        return $next($request);
    }
}
