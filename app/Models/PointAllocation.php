<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Запись о ручном распределении очков персонажа в конкретную характеристику или навык.
 * Одна строка на каждую цель (одна запись для Силы, одна для Атлетики и т.д.).
 * Стоимость в очках не хранится — вычисляется: характеристика × 20, навык × 10.
 * Сервер валидирует, что суммарные расходы не превышают выданный персонажу бюджет.
 */
class PointAllocation extends Model
{
    protected $fillable = [
        'character_id',
        'allocatable_type',
        'allocatable_id',
        'amount',
    ];

    /** Персонаж, которому принадлежит данное распределение. */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /** Цель распределения: характеристика (Ability) или навык (Skill). */
    public function allocatable(): MorphTo
    {
        return $this->morphTo();
    }
}
