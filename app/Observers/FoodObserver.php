<?php

namespace App\Observers;

use App\Models\Food;
use Illuminate\Support\Facades\Storage;

class FoodObserver
{
    /**
     * Handle the Food "created" event.
     */
    public function created(Food $food): void
    {
        //
    }

    /**
     * Handle the Food "updated" event.
     */
    public function updated(Food $food): void
    {
        if ($food->isDirty('image_path')) {
            Storage::disk('public')->delete($food->getOriginal('image_path'));
        }
    }

    /**
     * Handle the Food "deleted" event.
     */
    public function deleted(Food $food): void
    {
        if (! is_null($food->image_path)) {
            Storage::disk('public')->delete($food->image_path);
        }
    }

    /**
     * Handle the Food "restored" event.
     */
    public function restored(Food $food): void
    {
        //
    }

    /**
     * Handle the Food "force deleted" event.
     */
    public function forceDeleted(Food $food): void
    {
        //
    }
}
