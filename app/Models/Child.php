<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Child extends Model
{
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
     * Umur dalam bulan penuh (WHO: floor dari selisih hari / rata-rata panjang bulan).
     * Month-arithmetic (diffInMonths) membulatkan ke atas/gagal memplot titik
     * pengukuran yang jadwalnya meleset beberapa hari dari tanggal lahir.
     */
    public function ageInMonthsAt(\DateTimeInterface $date): int
    {
        return max(0, (int) floor($this->birth_date->diffInDays($date) / 30.4375));
    }

    /**
     * Umur saat ini dalam bulan.
     */
    public function ageInMonths(): int
    {
        return $this->ageInMonthsAt(now());
    }
}
