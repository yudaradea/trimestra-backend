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
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, Hasmedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, InteractsWithMedia;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role', // Tambahkan role
        'fingerprint_enabled',
        'device_connected',
        'device_id',
        'profile_photo',
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


    // Register media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')
            ->singleFile(); // Hanya satu foto profile
    }


    // Scope untuk role
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeRegularUser($query)
    {
        return $query->where('role', 'user');
    }

    // Cek role
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // Get profile photo URL
    public function getProfilePhotoUrlAttribute()
    {
        return $this->getFirstMediaUrl('profile_photo') ?:
            'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    // Relasi tetap sama...
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

    public function onboardingProgress()
    {
        return $this->hasOne(OnboardingProgress::class);
    }
}
