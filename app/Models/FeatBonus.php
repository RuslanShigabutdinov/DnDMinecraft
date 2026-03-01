<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Числовой бонус, который черта предоставляет к характеристике, навыку или показателю.
 * Использует полиморфную связь — одна запись может ссылаться на Ability, Skill или Stat.
 * Запись отсутствует, если черта является чисто описательной (без числовых эффектов).
 */
class FeatBonus extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'feat_id',
        'modifiable_type',
        'modifiable_id',
        'value',
    ];

    /** Черта, к которой относится данный бонус. */
    public function feat(): BelongsTo
    {
        return $this->belongsTo(Feat::class);
    }

    /** Цель бонуса: характеристика (Ability), навык (Skill) или показатель (Stat). */
    public function modifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
