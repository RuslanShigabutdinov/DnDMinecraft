<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Черта — пассивная особенность персонажа, покупаемая за очки.
 * Может давать числовые бонусы (например, +5 к Восприятию) или быть чисто описательной.
 * Редкость определяет стоимость черты. Если указан class_id — черта эксклюзивна для этого класса.
 * Одна черта не может быть куплена дважды одним персонажем. Легендарных черт — не более одной.
 */
class Feat extends Model
{
    protected $fillable = [
        'name',
        'description',
        'rarity_id',
        'class_id',
    ];

    /** Редкость черты, определяющая её стоимость в очках. */
    public function rarity(): BelongsTo
    {
        return $this->belongsTo(Rarity::class);
    }

    /** Класс, которому эксклюзивно принадлежит черта. Null — черта доступна всем. */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /** Числовые бонусы, которые даёт данная черта (если есть). */
    public function bonuses(): HasMany
    {
        return $this->hasMany(FeatBonus::class);
    }

    /** Персонажи, которые приобрели данную черту. */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_feats')
            ->withPivot('meta')
            ->withTimestamps();
    }

    public function isClassExclusive(): bool
    {
        return $this->class_id !== null;
    }
}
