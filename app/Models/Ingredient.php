<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'unit', 'calories', 'protein', 'fat',
        'carbohydrates', 'fiber', 'calcium', 'iron',
        'vitamin_a', 'vitamin_c',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredients')
                    ->withPivot('quantity_grams')
                    ->withTimestamps();
    }

    /**
     * Calculate nutrition for a given weight in grams.
     */
    public function nutritionFor(float $grams): array
    {
        $factor = $grams / 100;
        return [
            'calories'      => round($this->calories * $factor, 2),
            'protein'       => round($this->protein * $factor, 2),
            'fat'           => round($this->fat * $factor, 2),
            'carbohydrates' => round($this->carbohydrates * $factor, 2),
            'fiber'         => round($this->fiber * $factor, 2),
            'calcium'       => round($this->calcium * $factor, 2),
            'iron'          => round($this->iron * $factor, 2),
            'vitamin_a'     => round($this->vitamin_a * $factor, 2),
            'vitamin_c'     => round($this->vitamin_c * $factor, 2),
        ];
    }
}
