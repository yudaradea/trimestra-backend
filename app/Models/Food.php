<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;



class Food extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'image_path',
        'calories',
        'protein',
        'carbs',
        'fat',
        'fiber',
        'serving_size',
        'cooking_time',
        'is_pregnancy_safe',
        'allergens',
        'diet_types',
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
        'allergens' => 'array',
        'diet_types' => 'array',
        'is_active' => 'boolean',
    ];

    // Index untuk query optimization
    protected $with = ['category']; // Eager load category by default

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

    // Scope untuk query optimization
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePregnancySafe($query)
    {
        return $query->where('is_pregnancy_safe', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeCalorieRange($query, $min, $max)
    {
        return $query->whereBetween('calories', [$min, $max]);
    }
}
