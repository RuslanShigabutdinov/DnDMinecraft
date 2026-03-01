<?php

namespace App\Models;

use App\Enums\SkillSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Навык персонажа (Расследование, Восприятие, Убеждение и т.д.).
 * Справочная таблица с ~18 фиксированными записями. Каждый навык привязан
 * к одной базовой характеристике — именно её модификатор используется при проверке.
 * Базовое значение навыка равно 0. Максимальный бонус от всех источников — +10.
 */
class Skill extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ability_id',
        'name',
        'slug',
    ];

    protected function casts(): array
    {
        return [
            'slug' => SkillSlug::class,
        ];
    }

    /** Базовая характеристика, к которой относится навык (например, Расследование → Интеллект). */
    public function ability(): BelongsTo
    {
        return $this->belongsTo(Ability::class);
    }

    /** Бонусы к данному навыку, предоставляемые классами персонажей. */
    public function classBonuses(): MorphMany
    {
        return $this->morphMany(ClassBonus::class, 'modifiable');
    }

    /** Бонусы к данному навыку, предоставляемые чертами. */
    public function featBonuses(): MorphMany
    {
        return $this->morphMany(FeatBonus::class, 'modifiable');
    }

    /** Записи ручного распределения очков игроками в данный навык. */
    public function pointAllocations(): MorphMany
    {
        return $this->morphMany(PointAllocation::class, 'allocatable');
    }
}
