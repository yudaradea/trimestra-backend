<?php

namespace App\Observers;

use App\Models\FoodCategory;
use Illuminate\Support\Facades\Storage;

class FoodCategoryObserver
{
    /**
     * Handle the FoodCategory "created" event.
     */
    public function created(FoodCategory $foodCategory): void
    {
        //
    }

    /**
     * Handle the FoodCategory "updated" event.
     */
    public function updated(FoodCategory $foodCategory): void
    {
        if ($foodCategory->isDirty('image_path')) {
            Storage::disk('public')->delete($foodCategory->getOriginal('image_path'));
        }
    }

    /**
     * Handle the FoodCategory "deleted" event.
     */
    public function deleted(FoodCategory $foodCategory): void
    {
        if (! is_null($foodCategory->image_path)) {
            Storage::disk('public')->delete($foodCategory->image_path);
        }
    }

    /**
     * Handle the FoodCategory "restored" event.
     */
    public function restored(FoodCategory $foodCategory): void
    {
        //
    }

    /**
     * Handle the FoodCategory "force deleted" event.
     */
    public function forceDeleted(FoodCategory $foodCategory): void
    {
        //
    }
}
