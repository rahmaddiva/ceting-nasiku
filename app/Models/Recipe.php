<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'description',
        'instructions', 'servings', 'age_group', 'image', 'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredients')
                    ->withPivot('quantity_grams')
                    ->withTimestamps();
    }

    /**
     * Get total nutrition for this recipe.
     */
    public function getTotalNutritionAttribute(): array
    {
        $totals = [
            'calories' => 0, 'protein' => 0, 'fat' => 0,
            'carbohydrates' => 0, 'fiber' => 0, 'calcium' => 0,
            'iron' => 0, 'vitamin_a' => 0, 'vitamin_c' => 0,
        ];

        foreach ($this->ingredients as $ingredient) {
            $nutrition = $ingredient->nutritionFor($ingredient->pivot->quantity_grams);
            foreach ($totals as $key => &$value) {
                $value += $nutrition[$key];
            }
        }

        return array_map(fn($v) => round($v, 2), $totals);
    }

    /**
     * Get nutrition per serving.
     */
    public function getPerServingNutritionAttribute(): array
    {
        $total = $this->total_nutrition;
        $servings = max($this->servings, 1);
        return array_map(fn($v) => round($v / $servings, 2), $total);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
