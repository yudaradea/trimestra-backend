<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'meal_type',
        'food_id',
        'recipe_id',
        'quantity',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'exercise_type',
        'calories_burned',
        'exercise_duration',
        'device_id',
    ];

    protected $casts = [
        'date' => 'date',
        'quantity' => 'decimal:2',
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'calories_burned' => 'decimal:2',
        'exercise_duration' => 'integer',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
