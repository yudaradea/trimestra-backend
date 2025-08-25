<?php

namespace App\Services\Api;

use App\Models\Device;
use App\Models\ExerciseRecord;
use App\Models\DailyNutritionSummary;
use App\Models\User;
use App\Services\Api\UserService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class DeviceService
{
    private $userService;
    private $cacheTtl = 300; // 5 minutes

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function connectDevice(string $deviceUuid, User $user)
    {
        // Clear related caches
        $this->clearUserDeviceCaches($user->id);

        // Find or create device
        $device = Device::firstOrCreate(
            ['device_uuid' => $deviceUuid],
            [
                'name' => 'Smart Device ' . Str::random(6),
                'is_connected' => true
            ]
        );

        // Update user
        $user->update([
            'device_id' => $device->id,
            'device_connected' => true
        ]);

        $device->update(['is_connected' => true, 'last_sync' => now()]);

        return [
            'device' => $device,
            'user' => $user->fresh()
        ];
    }

    public function syncExercise(array $data, User $user)
    {
        // Validate device connection
        if (!$user->device_connected || !$user->device) {
            throw new \Exception('Device not connected');
        }

        // Create exercise record
        $exerciseData = array_merge(
            $data,
            [
                'user_id' => $user->id,
                'device_id' => $user->device_id
            ]
        );

        $exercise = ExerciseRecord::create($exerciseData);

        // Update daily nutrition summary
        $this->updateDailySummaryForExercise($user->id, $data['start_time']);

        // Clear related caches
        $date = date('Y-m-d', strtotime($data['start_time']));
        $this->clearUserDeviceCaches($user->id, $date);

        return $exercise;
    }

    private function clearUserDeviceCaches($userId, $date = null)
    {
        // Clear daily summary cache if date provided
        if ($date) {
            Cache::forget("daily_summary_{$userId}_{$date}");
        }

        // Clear device connection status cache
        Cache::forget("user_device_{$userId}");
    }

    private function updateDailySummaryForExercise($userId, $exerciseStartTime)
    {
        $date = date('Y-m-d', strtotime($exerciseStartTime));

        // Get user target calories
        $user = User::find($userId);
        $targetCalories = $this->userService->getUserTargetCalories($user);

        // Update or create daily nutrition summary
        $existingSummary = DailyNutritionSummary::where('user_id', $userId)
            ->where('date', $date)
            ->first();

        if ($existingSummary) {
            $existingSummary->increment('total_calories_burned', request('calories_burned', 0));
        } else {
            DailyNutritionSummary::create([
                'user_id' => $userId,
                'date' => $date,
                'total_calories_intake' => 0,
                'total_calories_burned' => request('calories_burned', 0),
                'total_protein' => 0,
                'total_carbs' => 0,
                'total_fat' => 0,
                'total_fiber' => 0,
                'target_calories' => $targetCalories,
            ]);
        }
    }
}
