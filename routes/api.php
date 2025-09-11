<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\UserFoodPreferenceController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\UserFavoriteController;
use App\Http\Controllers\Api\DiaryController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OnboardingController;



Route::prefix('v1')->group(function () {

    // 🔓 PUBLIC ROUTES - Tidak butuh authentication
    Route::post('register', [AuthController::class, 'register'])
        ->middleware('throttle:auth');
    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:auth');

    // 🍽️ PUBLIC FOOD & RECIPE ROUTES
    Route::get('foods', [FoodController::class, 'index'])
        ->middleware('throttle:api');
    Route::get('foods/search', [FoodController::class, 'search'])
        ->middleware('throttle:search');
    Route::get('foods/{id}', [FoodController::class, 'show'])
        ->middleware('throttle:api');
    Route::get('foods/category/{categoryId}', [FoodController::class, 'byCategory'])
        ->middleware('throttle:api');
    Route::get('categories', [FoodController::class, 'categories'])
        ->middleware('throttle:api');

    Route::get('recipes', [RecipeController::class, 'index'])
        ->middleware('throttle:api');
    Route::get('recipes/search', [RecipeController::class, 'search'])
        ->middleware('throttle:search');
    Route::get('recipes/{id}', [RecipeController::class, 'show'])
        ->middleware('throttle:api');

    // 🔐 PROTECTED ROUTES - Butuh authentication
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {

        // 🔐 AUTH
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        Route::post('user', [UserController::class, 'update']);
        Route::delete('user', [UserController::class, 'destroy']);

        // 🔄 ONBOARDING PROGRESS
        Route::get('onboarding/progress', [OnboardingController::class, 'getProgress']);
        Route::post('onboarding/progress', [OnboardingController::class, 'updateProgress']);

        // 👤 USER PROFILE SETUP
        Route::get('profile', [UserProfileController::class, 'show']);
        Route::post('profile', [UserProfileController::class, 'store']);

        // 🍽️ USER PREFERENCES SETUP
        Route::get('preferences', [UserFoodPreferenceController::class, 'show']);
        Route::post('preferences', [UserFoodPreferenceController::class, 'store']);

        // 📱 DEVICE INTEGRATION
        Route::post('device/connect', [DeviceController::class, 'connect'])
            ->name('api.v1.device.connect');

        // 🔒 ROUTES YANG BUTUH ONBOARDING SELESAI
        Route::middleware('onboarding.completed')->group(function () {

            // ⭐ FAVORITES
            Route::get('favorites', [UserFavoriteController::class, 'index']);
            Route::post('favorites', [UserFavoriteController::class, 'store']);
            Route::delete('favorites/{id}', [UserFavoriteController::class, 'destroy']);

            // 📓 DIARY
            Route::get('diary', [DiaryController::class, 'index']);
            Route::post('diary', [DiaryController::class, 'store']);
            Route::get('diary/summary', [DiaryController::class, 'summary']);
            Route::post('diary/sync-target-calories', [DiaryController::class, 'syncTargetCalories']);

            // 🏃 EXERCISE SYNC (dari alat - rate limit khusus)
            Route::post('device/sync-exercise', [DeviceController::class, 'syncExercise'])
                ->name('api.v1.device.sync-exercise')
                ->middleware('throttle:device-sync');

            // 🔔 NOTIFICATIONS
            Route::get('notifications', [NotificationController::class, 'index']);
            Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
            Route::post('notifications/read-all', [NotificationController::class, 'markAllAsRead']);

            // 🍳 RECOMMENDED FOODS (heavy endpoint)
            Route::get('personal-foods/recommended', [FoodController::class, 'recommended'])
                ->middleware('throttle:heavy');
        });
    });
});
