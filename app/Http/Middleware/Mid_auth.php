<?php

namespace App\Http\Middleware;

use Closure;

class Mid_auth
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
        if (\Cookie::get('mcul_token') === null){
            return redirect('login')->with('status', 'Permission Denied');   
        } 
        return $next($request);
    }
}
