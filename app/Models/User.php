<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, InteractsWithMedia, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'fingerprint_enabled',
        'device_connected',
        'device_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'fingerprint_enabled' => 'boolean',
        'device_connected' => 'boolean',
    ];

    // Relasi
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function preferences()
    {
        return $this->hasOne(UserFoodPreference::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class);
    }

    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class);
    }

    public function nutritionSummary()
    {
        return $this->hasMany(DailyNutritionSummary::class);
    }

    public function exerciseRecords()
    {
        return $this->hasMany(ExerciseRecord::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function notificationSettings()
    {
        return $this->hasOne(UserNotificationSetting::class);
    }
}
