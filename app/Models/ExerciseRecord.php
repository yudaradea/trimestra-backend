<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'device_id',
        'exercise_type',
        'duration',
        'calories_burned',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'duration' => 'integer',
        'calories_burned' => 'decimal:2',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
