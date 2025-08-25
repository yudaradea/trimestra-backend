<?php

namespace App\Services\Api;

use App\Models\User;

class UserService
{
    public function getUserTargetCalories(User $user)
    {
        $preferences = $user->preferences;

        if (!$preferences || $preferences->calorie_target === 'not_sure') {
            return 2000; // Default target
        }

        switch ($preferences->calorie_target) {
            case '<1500':
                return 1200;
            case '1500-2000':
                return 1800;
            case '>2000':
                return 2500;
            default:
                return 2000;
        }
    }
}
