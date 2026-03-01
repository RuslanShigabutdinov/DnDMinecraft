<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Медиафайл персонажа — как правило, арт или иллюстрация.
 * Хранит путь к файлу на диске, отображаемое имя и необязательное описание.
 * Привязан напрямую к персонажу.
 */
class CharacterMedia extends Model
{
    protected $fillable = [
        'character_id',
        'name',
        'file_path',
        'description',
    ];

    /** Персонаж, которому принадлежит данный медиафайл. */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}
