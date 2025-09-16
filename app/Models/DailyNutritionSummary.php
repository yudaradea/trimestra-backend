<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyNutritionSummary extends Model
{
    use HasFactory;

    protected $table = 'daily_nutrition_summary';

    protected $fillable = [
        'user_id',
        'date',
        'total_calories_intake',
        'total_calories_burned',
        'total_protein',
        'total_carbs',
        'total_fat',
        'total_fiber',
        'target_calories',
    ];

    protected $casts = [
        'date' => 'date',
        'total_calories_intake' => 'decimal:2',
        'total_calories_burned' => 'decimal:2',
        'total_protein' => 'decimal:2',
        'total_carbs' => 'decimal:2',
        'total_fat' => 'decimal:2',
        'total_fiber' => 'decimal:2',
        'target_calories' => 'decimal:2',
    ];

    //Accessor untuk Net Calories
    public function getNetCaloriesAttribute()
    {
        return ($this->total_calories_intake ?? 0) - ($this->total_calories_burned ?? 0);
    }

    //Accessor untuk Progress Percentage
    public function getCalorieProgressAttribute()
    {
        if ($this->target_calories > 0) {
            $progress = ($this->total_calories_intake / $this->target_calories) * 100;
            return round(min(100, max(0, $progress)), 2); // Batas 0-100%
        }
        return 0;
    }

    //Accessor untuk remaining calories
    public function getRemainingCaloriesAttribute()
    {
        return max(0, ($this->target_calories ?? 0) - ($this->total_calories_intake ?? 0));
    }
    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
