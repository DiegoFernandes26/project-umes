<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserNivel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $nivel)
    {
        if (Auth()->user()->nivel > $nivel):
            return redirect()->route('admin');
        endif;

        return $next($request);
    }
}
