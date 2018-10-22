<?php

namespace App\Http\Middleware;

use Closure;

class SuperUser {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (\Auth::check() && \App\Helper\Helper::isAdmin()){
            return $next($request);
        }elseif(\Auth::check() && ! \App\Helper\Helper::isAdmin()){
            return redirect('/?youarenotadmin');
        }
        return redirect('/superuser/login');
    }
}
