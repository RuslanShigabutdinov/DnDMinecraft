<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Шаблон текстового раздела листа персонажа (например, «Предыстория», «Ранние годы», «Мотивация»).
 * Справочная таблица, задаваемая администратором. Позволяет гибко расширять биографические поля
 * без изменения структуры базы данных — достаточно добавить новую запись в эту таблицу.
 * Флаг is_required указывает, обязателен ли раздел к заполнению при создании персонажа.
 */
class CharacterSection extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_required',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
        ];
    }

    /** Все заполненные записи данного раздела по всем персонажам. */
    public function details(): HasMany
    {
        return $this->hasMany(CharacterDetail::class);
    }
}
