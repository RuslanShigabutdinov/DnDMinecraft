<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Сводная таблица между персонажем и приобретёнными им чертами.
 * Хранит дополнительные данные (meta) для черт, требующих выбора при покупке —
 * например, черта «Академик» требует указать конкретный навык, к которому применяется бонус.
 */
class CharacterFeat extends Model
{
    protected $fillable = [
        'character_id',
        'feat_id',
        'meta',
    ];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    /** Персонаж, которому принадлежит данная черта. */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /** Черта, которую приобрёл персонаж. */
    public function feat(): BelongsTo
    {
        return $this->belongsTo(Feat::class);
    }
}
