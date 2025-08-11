<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Laravel\Scout\Searchable;

class Food extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'serving_size',
        'cooking_time',
        'is_pregnancy_safe',
        'is_active',
    ];

    protected $casts = [
        'calories' => 'decimal:2',
        'protein' => 'decimal:2',
        'carbs' => 'decimal:2',
        'fat' => 'decimal:2',
        'fiber' => 'decimal:2',
        'cooking_time' => 'integer',
        'is_pregnancy_safe' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Tentukan field yang bisa di-search
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }

    // Relasi
    public function category()
    {
        return $this->belongsTo(FoodCategory::class, 'category_id');
    }

    public function recipes()
    {
        return $this->hasOne(Recipe::class);
    }

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class);
    }

    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class);
    }
}
