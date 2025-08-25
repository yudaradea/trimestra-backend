<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property numeric $total_calories_intake
 * @property numeric $total_calories_burned
 * @property numeric $total_protein
 * @property numeric $total_carbs
 * @property numeric $total_fat
 * @property numeric $total_fiber
 * @property numeric $target_calories
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTargetCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTotalCaloriesBurned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTotalCaloriesIntake($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTotalCarbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTotalFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTotalFiber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereTotalProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DailyNutritionSummary whereUserId($value)
 */
	class DailyNutritionSummary extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $device_uuid
 * @property string $name
 * @property bool $is_connected
 * @property \Illuminate\Support\Carbon|null $last_sync
 * @property int|null $battery_level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DiaryEntry> $diaryEntries
 * @property-read int|null $diary_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExerciseRecord> $exerciseRecords
 * @property-read int|null $exercise_records_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereBatteryLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereDeviceUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereIsConnected($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereLastSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Device whereUpdatedAt($value)
 */
	class Device extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $date
 * @property string $meal_type
 * @property int|null $food_id
 * @property int|null $recipe_id
 * @property numeric|null $quantity
 * @property numeric|null $calories
 * @property numeric|null $protein
 * @property numeric|null $carbs
 * @property numeric|null $fat
 * @property numeric|null $fiber
 * @property string|null $exercise_type
 * @property numeric|null $calories_burned
 * @property int|null $exercise_duration
 * @property int|null $device_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device|null $device
 * @property-read \App\Models\Food|null $food
 * @property-read \App\Models\Recipe|null $recipe
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry byDate($date)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry exerciseEntries()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry mealEntries()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereCaloriesBurned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereCarbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereExerciseDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereExerciseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereFiber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereMealType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiaryEntry whereUserId($value)
 */
	class DiaryEntry extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $device_id
 * @property string $exercise_type
 * @property int $duration
 * @property numeric $calories_burned
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Device $device
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereCaloriesBurned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereExerciseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereUserId($value)
 */
	class ExerciseRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string|null $image_path
 * @property numeric $calories
 * @property numeric $protein
 * @property numeric $carbs
 * @property numeric $fat
 * @property numeric $fiber
 * @property string $serving_size
 * @property int|null $cooking_time
 * @property bool $is_pregnancy_safe
 * @property array<array-key, mixed>|null $allergens
 * @property array<array-key, mixed>|null $diet_types
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FoodCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DiaryEntry> $diaryEntries
 * @property-read int|null $diary_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFavorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Recipe|null $recipes
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food byCategory($categoryId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food calorieRange($min, $max)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food pregnancySafe()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereAllergens($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCalories($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCarbs($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCookingTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereDietTypes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereFat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereFiber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereIsPregnancySafe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereProtein($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereServingSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Food whereUpdatedAt($value)
 */
	class Food extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $image_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Food> $foods
 * @property-read int|null $foods_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FoodCategory whereUpdatedAt($value)
 */
	class FoodCategory extends \Eloquent {}
}

namespace App\Models\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $device_id
 * @property string $exercise_type
 * @property int $duration
 * @property string $calories_burned
 * @property string $start_time
 * @property string $end_time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereCaloriesBurned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereExerciseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ExerciseRecord whereUserId($value)
 */
	class ExerciseRecord extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $message
 * @property string $type
 * @property bool $is_read
 * @property array<array-key, mixed>|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int $current_step
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read OnboardingProgress|null $onboardingProgress
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereCurrentStep($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|OnboardingProgress whereUserId($value)
 */
	class OnboardingProgress extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $food_id
 * @property string $title
 * @property array<array-key, mixed> $ingredients
 * @property array<array-key, mixed> $instructions
 * @property int $prep_time
 * @property int $cook_time
 * @property int $servings
 * @property string $difficulty
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFavorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Food $food
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCookTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereIngredients($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereInstructions($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe wherePrepTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereServings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Recipe whereUpdatedAt($value)
 */
	class Recipe extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $phone
 * @property string|null $profile_photo
 * @property string $role
 * @property bool $fingerprint_enabled
 * @property bool $device_connected
 * @property int|null $device_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Device|null $device
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DiaryEntry> $diaryEntries
 * @property-read int|null $diary_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExerciseRecord> $exerciseRecords
 * @property-read int|null $exercise_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserFavorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read mixed $profile_photo_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\UserNotificationSetting|null $notificationSettings
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DailyNutritionSummary> $nutritionSummary
 * @property-read int|null $nutrition_summary_count
 * @property-read \App\Models\OnboardingProgress|null $onboardingProgress
 * @property-read \App\Models\UserFoodPreference|null $preferences
 * @property-read \App\Models\UserProfile|null $profile
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User admin()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User regularUser()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeviceConnected($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFingerprintEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property int|null $food_id
 * @property int|null $recipe_id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Food|null $food
 * @property-read \App\Models\Recipe|null $recipe
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereFoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereRecipeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFavorite whereUserId($value)
 */
	class UserFavorite extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property string $diet_type
 * @property array<array-key, mixed> $allergies
 * @property array<array-key, mixed> $preferred_meal_times
 * @property string $calorie_target
 * @property string $cooking_time_preference
 * @property string $serving_preference
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereAllergies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereCalorieTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereCookingTimePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereDietType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference wherePreferredMealTimes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereServingPreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFoodPreference whereUserId($value)
 */
	class UserFoodPreference extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property bool $enabled
 * @property bool $sound_enabled
 * @property bool $vibration_enabled
 * @property bool $silent_mode
 * @property bool $lock_screen
 * @property bool $reminders_enabled
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereLockScreen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereRemindersEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereSilentMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereSoundEnabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserNotificationSetting whereVibrationEnabled($value)
 */
	class UserNotificationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $birth_date
 * @property numeric $height
 * @property numeric $weight
 * @property bool $is_pregnant
 * @property int|null $pregnancy_weeks
 * @property bool|null $is_first_pregnancy
 * @property string $diet_preference
 * @property array<array-key, mixed> $health_goals
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereDietPreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereHealthGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereIsFirstPregnancy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereIsPregnant($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile wherePregnancyWeeks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserProfile whereWeight($value)
 */
	class UserProfile extends \Eloquent {}
}

