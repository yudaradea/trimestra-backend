<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\UserFoodPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\User\PreferencesRequest;

class UserFoodPreferenceController extends BaseController
{
    /**
     * Get user food preferences
     */
    public function show(Request $request)
    {
        $preferences = Auth::user()->preferences;

        if (!$preferences) {
            return $this->sendError('Preferences not found.');
        }

        return $this->sendResponse($preferences, 'Preferences retrieved successfully.');
    }

    /**
     * Create/Update user food preferences
     */
    public function store(PreferencesRequest $request)
    {
        // Validation handled by PreferencesRequest
        $user = Auth::user();
        $preferences = $user->preferences()->updateOrCreate(
            ['user_id' => $user->id],
            $request->validated()
        );

        // Update onboarding progress
        $user->onboardingProgress()->update(['current_step' => 3]);

        return $this->sendResponse($preferences, 'Preferences saved successfully.');
    }
}
