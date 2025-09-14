<?php

namespace App\Services\Api;

use App\Models\Food;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FoodRecommendationService
{
    private $cacheTtl = 300; // 5 minutes

    public function getRecommendedFoods(User $user)
    {
        $cacheKey = "recommended_foods_{$user->id}_" . md5(serialize([
            $user->profile?->toArray(),
            $user->preferences?->toArray()
        ]));

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($user) {
            Log::info('Getting food recommendations (cache miss)', [
                'user_id' => $user->id
            ]);

            // Base query
            $query = Food::with('category')
                ->where('is_active', true);

            // Apply all filters
            $this->applyFilters($query, $user);

            // Get results with fallback
            $foods = $this->getResultsWithFallback($query, $user);

            return $foods;
        });
    }

    public function clearUserRecommendationCache(User $user)
    {
        $cacheKey = "recommended_foods_{$user->id}_" . md5(serialize([
            $user->profile?->toArray(),
            $user->preferences?->toArray()
        ]));

        Cache::forget($cacheKey);
    }

    private function applyFilters($query, User $user)
    {
        $this->applyPregnancyFilter($query, $user->profile);
        $this->applyAllergyFilter($query, $user->preferences);
        $this->applyCalorieFilter($query, $user->preferences);
        $this->applyCookingTimeFilter($query, $user->preferences);
        $this->applyDietTypeFilter($query, $user->preferences);
    }

    private function applyPregnancyFilter($query, $profile)
    {
        if ($profile && $profile->is_pregnant) {
            $query->where('is_pregnancy_safe', true);
        }
    }

    private function applyAllergyFilter($query, $preferences)
    {
        if ($preferences && !empty($preferences->allergies) && !in_array('tidak ada', $preferences->allergies)) {
            $allergies = array_filter($preferences->allergies, function ($allergy) {
                return $allergy !== 'tidak ada' && !empty($allergy);
            });

            foreach ($allergies as $allergy) {
                $query->where(function ($q) use ($allergy) {
                    $q->whereNull('allergens')
                        ->orWhere('allergens', '[]')
                        ->orWhere('allergens', 'not like', '%"' . $allergy . '"%');
                });
            }
        }
    }

    private function applyCalorieFilter($query, $preferences)
    {
        if ($preferences && $preferences->calorie_target && $preferences->calorie_target !== 'not_sure') {
            switch ($preferences->calorie_target) {
                case '<1500':
                    $query->where('calories', '<=', 500);
                    break;
                case '1500-2000':
                    $query->whereBetween('calories', [200, 800]);
                    break;
                case '>2000':
                    $query->where('calories', '>=', 500);
                    break;
            }
        }
    }
    private function applyCookingTimeFilter($query, $preferences)
    {
        if ($preferences && $preferences->cooking_time_preference && $preferences->cooking_time_preference !== 'not_sure') {
            switch ($preferences->cooking_time_preference) {
                case '<15':
                    // ✅ PERBAIKAN: Filter yang benar untuk < 15 menit
                    $query->where(function ($q) {
                        $q->where('cooking_time', '<', 15)
                            ->orWhereNull('cooking_time');
                    });
                    break;

                case '15-30':
                    // ✅ PERBAIKAN: Filter yang benar untuk 15-30 menit
                    $query->whereBetween('cooking_time', [15, 30]);
                    break;

                case '>30':
                    // ✅ PERBAIKAN: Filter yang benar untuk > 30 menit
                    $query->where('cooking_time', '>', 30);
                    break;
            }
        }
    }

    private function applyDietTypeFilter($query, $preferences)
    {
        if ($preferences && $preferences->diet_type && $preferences->diet_type !== 'no_preference') {
            $query->where(function ($q) use ($preferences) {
                $q->whereNull('diet_types')
                    ->orWhere('diet_types', '[]')
                    ->orWhere('diet_types', 'like', '%"' . $preferences->diet_type . '"%');
            });
        }
    }

    private function getResultsWithFallback($query, User $user)
    {
        $foods = $query->inRandomOrder()->limit(20)->get();

        // Fallback jika tidak ada hasil
        if ($foods->isEmpty()) {
            $fallbackQuery = Food::with('category')
                ->where('is_active', true);

            // Tetap apply safety filters
            $this->applyPregnancyFilter($fallbackQuery, $user->profile);
            $this->applyAllergyFilter($fallbackQuery, $user->preferences);

            $foods = $fallbackQuery->inRandomOrder()->limit(20)->get();
        }

        // Ultimate fallback
        if ($foods->isEmpty()) {
            $foods = Food::with('category')
                ->where('is_active', true)
                ->inRandomOrder()
                ->limit(20)
                ->get();
        }

        // Apply serving preference limit
        if ($user->preferences && $user->preferences->serving_preference) {
            $foods = $this->applyServingLimit($foods, $user->preferences->serving_preference);
        }

        return $foods;
    }

    private function applyServingLimit($foods, $servingPreference)
    {
        if ($servingPreference === '>5') {
            if ($foods->count() > 5) {
                $maxLimit = min(10, $foods->count());
                $minLimit = 6;
                if ($minLimit <= $maxLimit) {
                    $randomLimit = rand($minLimit, $maxLimit);
                    return $foods->shuffle()->take($randomLimit);
                }
            }
            return $foods;
        } else {
            $limit = (int) $servingPreference;
            if ($limit > 0 && $limit <= 20) {
                if ($foods->count() > $limit) {
                    return $foods->shuffle()->take($limit);
                }
            }
            return $foods;
        }
    }
}
