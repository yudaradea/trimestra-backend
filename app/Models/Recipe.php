<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Recipe extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'food_id',
        'title',
        'ingredients',
        'instructions',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'ingredients' => 'array',
        'instructions' => 'array',
        'prep_time' => 'integer',
        'cook_time' => 'integer',
        'servings' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relasi
    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function favorites()
    {
        return $this->hasMany(UserFavorite::class);
    }
}
