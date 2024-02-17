<?php

namespace App\Http\Middleware;
use Closure;
use Session;

class SessionCheckUser
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
        if(!Session::has('user_id'))
        {
            $request->session()->flash('alert-danger', 'Session Expired !!!');
            return redirect('user/login');
        }
        return $next($request);
    }
}
