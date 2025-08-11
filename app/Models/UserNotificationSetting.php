<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enabled',
        'sound_enabled',
        'vibration_enabled',
        'silent_mode',
        'lock_screen',
        'reminders_enabled',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'sound_enabled' => 'boolean',
        'vibration_enabled' => 'boolean',
        'silent_mode' => 'boolean',
        'lock_screen' => 'boolean',
        'reminders_enabled' => 'boolean',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
