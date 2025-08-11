<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFoodPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'diet_type',
        'allergies',
        'preferred_meal_times',
        'calorie_target',
        'cooking_time_preference',
        'serving_preference',
    ];

    protected $casts = [
        'allergies' => 'array',
        'preferred_meal_times' => 'array',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
