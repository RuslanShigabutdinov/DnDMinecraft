<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Персонаж игрока — центральная сущность всей системы.
 * Хранит базовую информацию (имя, пол, возраст, физические параметры).
 * Все числовые показатели (характеристики, навыки, HP, AC) вычисляются динамически
 * из бонусов класса, приобретённых черт и ручного распределения очков — никогда не хранятся напрямую.
 * Текущее состояние в бою (current_hp, temporary_hp, sanity_meter) хранится как мутабельное состояние.
 * Текстовые описания (внешность и т.д.) хранятся через CharacterDetail.
 */
class Character extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'alignment_id',
        'name',
        'background',
        'gender',
        'age',
        'height',
        'weight',
        'size',
        'current_hp',
        'temporary_hp',
        'sanity_meter',
    ];

    /** Владелец персонажа. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Класс персонажа, определяющий базовые бонусы и доступные черты. */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /** Мировоззрение персонажа (косметика). */
    public function alignment(): BelongsTo
    {
        return $this->belongsTo(Alignment::class);
    }

    /** Черты, приобретённые персонажем за очки. Через сводную таблицу character_feats. */
    public function feats(): BelongsToMany
    {
        return $this->belongsToMany(Feat::class, 'character_feats')
            ->withPivot('meta')
            ->withTimestamps();
    }

    /** Записи ручного распределения очков персонажа по характеристикам и навыкам. */
    public function pointAllocations(): HasMany
    {
        return $this->hasMany(PointAllocation::class);
    }

    /** Заполненные текстовые разделы биографии персонажа. */
    public function details(): HasMany
    {
        return $this->hasMany(CharacterDetail::class);
    }

    /** Медиафайлы (арты, иллюстрации), прикреплённые к данному персонажу. */
    public function media(): HasMany
    {
        return $this->hasMany(CharacterMedia::class);
    }
}
