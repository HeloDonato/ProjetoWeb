<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
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
        if(Auth::check() and Auth::user()->tipoGrupo != 'admin' and Auth::user()->tipoGrupo != 'super')
            return abort(403, 'Acesso negado!');
        else
            return $next($request);

    }
}