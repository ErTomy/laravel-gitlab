<?php

namespace Ertomy\Gitlab\Middleware;

use Closure;
use Illuminate\Http\Request;


class AuthDeployUsers
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
        if (! in_array(auth()->user()->id, config('gitdeploy.users_id'))) {
            return redirect()->route('login');    
        }        
        return $next($request);
    }
}
