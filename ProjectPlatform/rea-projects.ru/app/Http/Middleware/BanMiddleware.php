<?php

namespace App\Http\Middleware;

use App\Models\Ban;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BanMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user() == null) {
            return back();
        }

        if(Ban::where(['banned_user_id' => Auth::user()->id])->first()) {
            return back()->withErrors(['error' => 'Вы были забанены!']);
        }

        return $next($request);
    }
}
