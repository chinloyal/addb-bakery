<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\MessageBag;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
		if(auth()->guest()){
			return redirect()->route('auth.login');
		}

		$roles = is_array($role)
		? $role
		: explode('|', $role);

		if(auth()->user()->inRole($roles)){
			return $next($request);
		}

		$errors = new MessageBag([
			"User is not a $role."
		]);

		if($request->expectsJson()) {
			return response()->json($errors->getMessages(), 401);
		}

		return redirect()->back()->withErrors($errors);
    }
}
