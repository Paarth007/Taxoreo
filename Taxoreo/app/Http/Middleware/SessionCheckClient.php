<?php

namespace App\Http\Middleware;
use Closure;
use Session;

class SessionCheckClient
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
            return redirect('client/login');
        }
        return $next($request);
    }
}
