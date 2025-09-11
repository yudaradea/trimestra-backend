<?php

namespace App\Services\Api;

use App\Models\DiaryEntry;
use App\Models\DailyNutritionSummary;
use App\Models\Food;
use App\Models\Recipe;
use App\Models\User;
use App\Services\Api\UserService;
use Illuminate\Support\Facades\Cache;

class DiaryService
{
    private $userService;
    private $cacheTtl = 300; // 5 minutes

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function createDiaryEntry(array $data, User $user)
    {
        // Calculate nutrition values
        $this->calculateNutritionValues($data);

        // Create diary entry
        $entry = $user->diaryEntries()->create($data);

        // Update daily summary
        $this->updateDailySummary($user->id, $data['date']);

        // Clear related caches
        $this->clearRelatedCaches($user->id, $data['date']);

        return $entry;
    }

    private function calculateNutritionValues(&$data)
    {
        if (isset($data['food_id']) && isset($data['quantity'])) {
            $food = Food::find($data['food_id']);
            if ($food) {
                $data['calories'] = $food->calories * $data['quantity'];
                $data['protein'] = $food->protein * $data['quantity'];
                $data['carbs'] = $food->carbs * $data['quantity'];
                $data['fat'] = $food->fat * $data['quantity'];
                $data['fiber'] = $food->fiber * $data['quantity'];
            }
        } elseif (isset($data['recipe_id']) && isset($data['quantity'])) {
            $recipe = Recipe::with('food')->find($data['recipe_id']);
            if ($recipe && $recipe->food) {
                $data['calories'] = $recipe->food->calories * $data['quantity'];
                $data['protein'] = $recipe->food->protein * $data['quantity'];
                $data['carbs'] = $recipe->food->carbs * $data['quantity'];
                $data['fat'] = $recipe->food->fat * $data['quantity'];
                $data['fiber'] = $recipe->food->fiber * $data['quantity'];
            }
        }
    }


    public function updateDailySummary($userId, $date)
    {
        // Get user target calories
        $user = User::with('profile')->find($userId);

        $entries = DiaryEntry::where('user_id', $userId)
            ->where('date', $date)
            ->get();

        $summary = [
            'total_calories_intake' => 0,
            'total_calories_burned' => 0,
            'total_protein' => 0,
            'total_carbs' => 0,
            'total_fat' => 0,
            'total_fiber' => 0,
        ];

        foreach ($entries as $entry) {
            if (in_array($entry->meal_type, ['breakfast', 'lunch', 'dinner', 'snack'])) {
                $summary['total_calories_intake'] += $entry->calories ?? 0;
                $summary['total_protein'] += $entry->protein ?? 0;
                $summary['total_carbs'] += $entry->carbs ?? 0;
                $summary['total_fat'] += $entry->fat ?? 0;
                $summary['total_fiber'] += $entry->fiber ?? 0;
            }
        }

        // Add calories burned from exercise records
        $exerciseRecords = \App\Models\ExerciseRecord::where('user_id', $userId)
            ->whereDate('start_time', $date)
            ->get();

        foreach ($exerciseRecords as $record) {
            $summary['total_calories_burned'] += $record->calories_burned ?? 0;
        }


        $targetCalories = $this->getUserTargetCalories($user);

        DailyNutritionSummary::updateOrCreate(
            ['user_id' => $userId, 'date' => $date],
            array_merge($summary, ['target_calories' => $targetCalories])
        );
    }

    public function getDailySummary($userId, $date)
    {
        $cacheKey = "daily_summary_{$userId}_{$date}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($userId, $date) {
            $summary = DailyNutritionSummary::where('user_id', $userId)
                ->where('date', $date)
                ->first();

            // If no summary exists, create default one
            if (!$summary) {
                $user = User::with('profile')->find($userId);
                $targetCalories = $this->getUserTargetCalories($user);

                $summary = DailyNutritionSummary::create([
                    'user_id' => $userId,
                    'date' => $date,
                    'total_calories_intake' => 0,
                    'total_calories_burned' => 0,
                    'total_protein' => 0,
                    'total_carbs' => 0,
                    'total_fat' => 0,
                    'total_fiber' => 0,
                    'target_calories' => $targetCalories,
                ]);
            }


            return $summary;
        });
    }

    public function getUserTargetCalories($user)
    {
        if ($user->profile && $user->profile->target_calories) {
            return $user->profile->target_calories;
        }

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

    // ✅ TAMBAHKAN: Method untuk force update target calories
    public function syncTargetCalories($userId, $date = null)
    {
        $date = $date ?: date('Y-m-d');

        // Get user dengan profile
        $user = User::with('profile')->find($userId);

        // Dapatkan target calories terbaru
        $targetCalories = $this->getUserTargetCalories($user);

        // Update daily nutrition summary
        $summary = DailyNutritionSummary::where('user_id', $userId)
            ->where('date', $date)
            ->first();

        if ($summary) {
            $summary->update(['target_calories' => $targetCalories]);
        } else {
            // Create new summary jika belum ada
            DailyNutritionSummary::create([
                'user_id' => $userId,
                'date' => $date,
                'total_calories_intake' => 0,
                'total_calories_burned' => 0,
                'total_protein' => 0,
                'total_carbs' => 0,
                'total_fat' => 0,
                'total_fiber' => 0,
                'target_calories' => $targetCalories,
            ]);
        }

        return $targetCalories;
    }

    public function getRecentDiaryEntries($userId, $limit = 10)
    {
        return DiaryEntry::with(['food', 'recipe'])
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private function clearRelatedCaches($userId, $date)
    {
        // Clear daily summary cache
        Cache::forget("daily_summary_{$userId}_{$date}");

        // Clear diary entries cache
        Cache::forget("diary_entries_{$userId}_{$date}");

        // Clear user recommendation cache (karena nutrisi berubah)
        $user = User::find($userId);
        if ($user) {
            app(FoodRecommendationService::class)->clearUserRecommendationCache($user);
        }
    }
}
