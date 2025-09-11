<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birth_date',
        'height',
        'weight',
        'is_pregnant',
        'pregnancy_weeks',
        'is_first_pregnancy',
        'diet_preference',
        'target_calories',
        'health_goals',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
        'is_pregnant' => 'boolean',
        'is_first_pregnancy' => 'boolean',
        'health_goals' => 'array',
        'target_calories' => 'integer',
        'pregnancy_weeks' => 'integer',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
