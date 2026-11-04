<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrowthStandard extends Model
{
    protected $fillable = ['sex', 'indicator', 'age_months', 'l', 'm', 's'];

    protected $casts = [
        'l' => 'float',
        'm' => 'float',
        's' => 'float',
    ];
}
