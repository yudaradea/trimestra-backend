<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(Auth::user()->id);
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
