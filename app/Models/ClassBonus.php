<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Числовой бонус, который класс персонажа предоставляет к характеристике, навыку или показателю.
 * Использует полиморфную связь — одна запись может ссылаться на Ability, Skill или Stat.
 * Данные справочные и задаются администратором при настройке классов.
 */
class ClassBonus extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'modifiable_type',
        'modifiable_id',
        'value',
    ];

    /** Класс персонажа, которому принадлежит данный бонус. */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /** Цель бонуса: характеристика (Ability), навык (Skill) или показатель (Stat). */
    public function modifiable(): MorphTo
    {
        return $this->morphTo();
    }
}
