<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserFoodPreference;
use App\Models\UserNotificationSetting;
use App\Models\OnboardingProgress;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        $admin = User::create([
            'name' => 'Admin TRIMESTRA',
            'email' => 'admin@trimestra.test',
            'password' => Hash::make('admin123'),
            'phone' => '081234567890',
            'role' => 'admin',
            'fingerprint_enabled' => false,
            'device_connected' => false,
        ]);

        // Sample regular user dengan data lengkap
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@trimestra.test',
            'password' => Hash::make('user123'),
            'phone' => '081234567891',
            'role' => 'user',
            'fingerprint_enabled' => true,
            'device_connected' => false,
        ]);

        // User profile
        $user->profile()->create([
            'birth_date' => '1990-01-01',
            'height' => 165.5,
            'weight' => 60.0,
            'is_pregnant' => true,
            'pregnancy_weeks' => 20,
            'is_first_pregnancy' => false,
            'diet_preference' => 'normal',
            'health_goals' => ['menjaga_kehamilan_sehat', 'menambah_energi'],
        ]);

        // User preferences
        $user->preferences()->create([
            'diet_type' => 'no_preference',
            'allergies' => ['telur'],
            'preferred_meal_times' => ['breakfast', 'lunch'],
            'calorie_target' => '1500-2000',
            'cooking_time_preference' => '15-30',
            'serving_preference' => '3',
        ]);

        // Notification settings
        $user->notificationSettings()->create([
            'enabled' => true,
            'sound_enabled' => true,
            'vibration_enabled' => true,
            'silent_mode' => false,
            'lock_screen' => true,
            'reminders_enabled' => true,
        ]);

        // Onboarding progress
        $user->onboardingProgress()->create([
            'current_step' => 4,
            'completed' => true,
            'completed_at' => now(),
        ]);
    }
}
