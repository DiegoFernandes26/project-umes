<?php

namespace App\Http\Middleware;

use Closure;

class CheckSystemConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = \App\Configuracoes::orderBy('id')->get();
//        dd(count($config));
        if (count($config)<=0):
            return redirect()->route('config.create');
        endif;
        return $next($request);
    }
}
