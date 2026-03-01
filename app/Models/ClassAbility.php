<?php

namespace App\Models;

use App\Enums\ActionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Игровая способность класса персонажа (например, «Дипломат», «Вспышка гениальности»).
 * Является текстовым описанием для ролевых механик и не влияет на числовые показатели напрямую.
 * Тип действия (action_type) определяет, когда способность применяется: пассивно, как реакция и т.д.
 */
class ClassAbility extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'class_id',
        'name',
        'description',
        'action_type',
    ];

    protected function casts(): array
    {
        return [
            'action_type' => ActionType::class,
        ];
    }

    /** Класс персонажа, которому принадлежит данная способность. */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }
}
