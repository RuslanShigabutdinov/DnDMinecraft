<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Мировоззрение персонажа — моральная и этическая позиция по стандарту D&D.
 * Справочная таблица с 9 фиксированными значениями (Lawful Good, Chaotic Evil и т.д.).
 * Носит исключительно косметический характер и не влияет на механику.
 */
class Alignment extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    /** Все персонажи с данным мировоззрением. */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
