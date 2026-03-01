<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Текстовый контент одного биографического раздела конкретного персонажа.
 * Пара «персонаж + раздел» уникальна — один персонаж заполняет каждый раздел один раз.
 * Такой подход позволяет добавлять новые разделы (CharacterSection) без миграций.
 */
class CharacterDetail extends Model
{
    protected $fillable = [
        'character_id',
        'character_section_id',
        'content',
    ];

    /** Персонаж, которому принадлежит данный текстовый блок. */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /** Раздел-шаблон, к которому относится данный текст (например, «Ранние годы»). */
    public function section(): BelongsTo
    {
        return $this->belongsTo(CharacterSection::class, 'character_section_id');
    }
}
