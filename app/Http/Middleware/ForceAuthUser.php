<?php

namespace App\Http\Middleware;

use Closure;

class ForceAuthUser
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
        $user = $request->session()->get('user');

        auth()->setUser(    \App\Models\User::find($user->id)   );

        return $next($request);
    }
}
