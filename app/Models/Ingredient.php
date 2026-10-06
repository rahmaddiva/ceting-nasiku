<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'unit', 'substitution_group', 'calories', 'protein', 'fat',
        'carbohydrates', 'fiber', 'calcium', 'iron',
        'vitamin_a', 'vitamin_c',
    ];

    protected $casts = [
        'calories' => 'float',
        'protein' => 'float',
        'fat' => 'float',
        'carbohydrates' => 'float',
        'fiber' => 'float',
        'calcium' => 'float',
        'iron' => 'float',
        'vitamin_a' => 'float',
        'vitamin_c' => 'float',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients')
            ->withPivot('quantity_grams')
            ->withTimestamps();
    }

    /**
     * Bahan lain dalam grup substitusi yang sama (tanpa diri sendiri).
     */
    public function substitutes()
    {
        if (! $this->substitution_group) {
            return collect();
        }

        return static::where('substitution_group', $this->substitution_group)
            ->whereKeyNot($this->getKey())
            ->orderBy('name')
            ->get();
    }

    /**
     * Calculate nutrition for a given weight in grams.
     */
    public function nutritionFor(float $grams): array
    {
        $factor = $grams / 100;

        return [
            'calories' => round($this->calories * $factor, 2),
            'protein' => round($this->protein * $factor, 2),
            'fat' => round($this->fat * $factor, 2),
            'carbohydrates' => round($this->carbohydrates * $factor, 2),
            'fiber' => round($this->fiber * $factor, 2),
            'calcium' => round($this->calcium * $factor, 2),
            'iron' => round($this->iron * $factor, 2),
            'vitamin_a' => round($this->vitamin_a * $factor, 2),
            'vitamin_c' => round($this->vitamin_c * $factor, 2),
        ];
    }
}
