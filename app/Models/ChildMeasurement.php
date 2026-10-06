<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildMeasurement extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'measured_at', 'weight_kg', 'height_cm', 'note'];

    protected $casts = [
        'measured_at' => 'date',
        'weight_kg' => 'float',
        'height_cm' => 'float',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }
}
