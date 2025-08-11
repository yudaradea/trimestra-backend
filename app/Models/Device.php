<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_uuid',
        'name',
        'is_connected',
        'last_sync',
        'battery_level',
    ];

    protected $casts = [
        'is_connected' => 'boolean',
        'last_sync' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function exerciseRecords()
    {
        return $this->hasMany(ExerciseRecord::class);
    }

    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class);
    }
}
