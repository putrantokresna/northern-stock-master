<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KaryawanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(session('user') != null) {
            if(session('user')->role != 'Karyawan')
                return redirect()->route('login');
        } else {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
