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

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
