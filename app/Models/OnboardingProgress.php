<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnboardingProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_step',
        'completed',
        'completed_at',
    ];

    protected $casts = [
        'current_step' => 'integer',
        'completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function onboardingProgress()
    {
        return $this->hasOne(OnboardingProgress::class);
    }
}
