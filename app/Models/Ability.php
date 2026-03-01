<?php

namespace App\Models;

use App\Enums\AbilitySlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Базовая характеристика персонажа (Сила, Ловкость, Телосложение и т.д.).
 * Справочная таблица из 6 фиксированных записей. Базовое значение всех характеристик — 10.
 * Итоговый показатель вычисляется динамически из бонусов класса, черт и ручного распределения очков.
 * Также является родительской сущностью для навыков — каждый навык привязан к одной характеристике.
 */
class Ability extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected function casts(): array
    {
        return [
            'slug' => AbilitySlug::class,
        ];
    }

    /** Навыки, которые управляются данной характеристикой (например, Атлетика → Сила). */
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    /** Бонусы к данной характеристике, предоставляемые классами персонажей. */
    public function classBonuses(): MorphMany
    {
        return $this->morphMany(ClassBonus::class, 'modifiable');
    }

    /** Бонусы к данной характеристике, предоставляемые чертами. */
    public function featBonuses(): MorphMany
    {
        return $this->morphMany(FeatBonus::class, 'modifiable');
    }

    /** Записи ручного распределения очков игроками в данную характеристику. */
    public function pointAllocations(): MorphMany
    {
        return $this->morphMany(PointAllocation::class, 'allocatable');
    }
}
