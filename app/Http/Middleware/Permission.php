<?php

namespace App\Http\Middleware;

use Closure;

class Permission
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
        // Getting current route name
        $routeName = $request->route()->getName();
        
        if( !$request->user()->hasPermission($routeName) 
            && strpos(url()->current(), 'sample') === false 
            && strpos(url()->current(), 'info') === false){
                return redirect()->route('dashboard')->with('error', 'Insufficient permissions to access that route!');
        }
        return $next($request);
    }
}
