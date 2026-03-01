<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс персонажа (Учёный, Воин и т.д.) — основная профессия/роль в игре.
 * Каждый класс предоставляет фиксированный набор бонусов к характеристикам и навыкам,
 * а также уникальные игровые способности (ролевые и боевые).
 * Класс также открывает доступ к эксклюзивным чертам, доступным только его представителям.
 * Примечание: модель называется CharacterClass, а не Class, так как Class — зарезервированное слово PHP.
 */
class CharacterClass extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    /** Числовые бонусы, которые класс даёт персонажу (к характеристикам, навыкам, HP, AC и т.д.). */
    public function bonuses(): HasMany
    {
        return $this->hasMany(ClassBonus::class, 'class_id');
    }

    /** Специальные игровые способности класса (пассивные, боевые, реактивные и т.д.). */
    public function abilities(): HasMany
    {
        return $this->hasMany(ClassAbility::class, 'class_id');
    }

    /** Черты, эксклюзивно доступные только для этого класса. */
    public function feats(): HasMany
    {
        return $this->hasMany(Feat::class, 'class_id');
    }

    /** Все персонажи, играющие за данный класс. */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'class_id');
    }
}
