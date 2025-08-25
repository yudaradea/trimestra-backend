<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\User\ProfileRequest;

class UserProfileController extends BaseController
{
    /**
     * Get user profile
     */
    public function show(Request $request)
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return $this->sendError('Profile not found.');
        }

        return $this->sendResponse($profile, 'Profile retrieved successfully.');
    }

    /**
     * Create/Update user profile
     */
    public function store(ProfileRequest $request)
    {
        // Validation handled by ProfileRequest
        $user = Auth::user();
        $profile = $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        // Update onboarding progress
        $user->onboardingProgress()->update(['current_step' => 2]);

        return $this->sendResponse($profile, 'Profile saved successfully.');
    }
}
