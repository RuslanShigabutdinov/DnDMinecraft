<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Редкость черты. Определяет стоимость черты в очках и её «уровень силы».
 * Справочная таблица с 4 значениями: обычная (50), необычная (75), редкая (100), легендарная (150).
 * Вынесена в отдельную таблицу, чтобы стоимость не дублировалась в каждой записи черты —
 * достаточно изменить одну строку редкости, и все черты этого уровня обновятся автоматически.
 */
class Rarity extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'point_cost',
    ];

    /** Все черты данной редкости. */
    public function feats(): HasMany
    {
        return $this->hasMany(Feat::class);
    }
}
