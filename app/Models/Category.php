<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'image'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function getImageAttribute($value)
    {
        if ($value && ! str_starts_with($value, 'images/')) {
            return 'images/'.$value;
        }

        return $value;
    }
}
