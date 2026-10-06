<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Child extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'gender', 'birth_date'];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function measurements(): HasMany
    {
        return $this->hasMany(ChildMeasurement::class)->orderBy('measured_at');
    }

    /**
     * Umur dalam bulan pada tanggal tertentu (floor, 30.4375 hari/bulan).
     */
    public function ageInMonthsAt(\DateTimeInterface $date): int
    {
        $days = $this->birth_date->diffInDays($date);

        return max(0, (int) floor($days / 30.4375));
    }

    /**
     * Umur saat ini dalam bulan.
     */
    public function ageInMonths(): int
    {
        return $this->ageInMonthsAt(now());
    }
}
