<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OnboardingController extends BaseController
{
    /**
     * Update onboarding progress
     */
    public function updateProgress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_step' => 'required|integer|min:1|max:4',
            'completed' => 'boolean',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $user = Auth::user();
        $progress = $user->onboardingProgress()->updateOrCreate(
            ['user_id' => $user->id],
            $request->all()
        );

        if ($request->completed) {
            $progress->update(['completed_at' => now()]);
        }

        return $this->sendResponse($progress, 'Onboarding progress updated.');
    }

    /**
     * Get onboarding progress
     */
    public function getProgress()
    {
        $progress = Auth::user()->onboardingProgress;

        return $this->sendResponse($progress ?: [], 'Onboarding progress retrieved.');
    }
}
