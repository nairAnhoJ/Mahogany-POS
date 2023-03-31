<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle(Request $request, Closure $next, $role1=null, $role2=null, $role3=null, $role4=null)
    {
        // if(!isset(auth()->user()->role) || auth()->user()->role != 0){
        //     return redirect('error');
        // }
        $roles = array($role1, $role2, $role3, $role4);
        if($request->user()){
            foreach($roles as $role){
                if($request->user()->role == $role){
                    return $next($request);
                }
            }
        }

        return redirect('error');
    }
}
