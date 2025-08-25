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

    public function getDailySummary($userId, $date)
    {
        $cacheKey = "daily_summary_{$userId}_{$date}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($userId, $date) {
            $summary = DailyNutritionSummary::where('user_id', $userId)
                ->where('date', $date)
                ->first();

            // If no summary exists, create default one
            if (!$summary) {
                $user = User::find($userId);
                $targetCalories = $this->userService->getUserTargetCalories($user);

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

    public function getDiaryEntries($userId, $date)
    {
        $cacheKey = "diary_entries_{$userId}_{$date}";

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($userId, $date) {
            return DiaryEntry::with(['food:id,name,calories,protein,carbs,fat,fiber', 'recipe:id,food_id,title'])
                ->where('user_id', $userId)
                ->where('date', $date)
                ->get();
        });
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

        // Get user target calories
        $user = User::find($userId);
        $targetCalories = $this->userService->getUserTargetCalories($user);

        DailyNutritionSummary::updateOrCreate(
            ['user_id' => $userId, 'date' => $date],
            array_merge($summary, ['target_calories' => $targetCalories])
        );
    }
}
