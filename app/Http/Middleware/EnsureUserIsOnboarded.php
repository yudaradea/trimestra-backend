<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsOnboarded
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Cek apakah user sudah menyelesaikan onboarding
        if (!$user->onboardingProgress || !$user->onboardingProgress->completed) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete onboarding first.',
                'redirect' => 'onboarding',
                'onboarding_progress' => $user->onboardingProgress ?? null
            ], 403);
        }

        return $next($request);
    }
}
