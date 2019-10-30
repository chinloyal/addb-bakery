<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Support\MessageBag;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
		if(auth()->guest()){
			return redirect()->route('auth.login');
		}

		if(auth()->user()->cando($permission) or
			auth()->user()->role->slug == Role::getAdmin()->slug){

			return $next($request);
		}

		$errors = new MessageBag([
			"User does not have to permission to $permission."
		]);

		if ($request->expectsJson()) {
			return response()->json($errors->getMessages(), 401);
		}

		return redirect()->back()->withErrors($errors);


    }
}
