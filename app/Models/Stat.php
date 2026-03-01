<?php

namespace App\Models;

use App\Enums\StatSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Производный показатель персонажа, не являющийся характеристикой или навыком.
 * Справочная таблица для значений вроде HP (очки здоровья), AC (класс брони),
 * инициативы и прочих числовых параметров, на которые могут влиять классы и черты.
 * Итоговое значение, как и у характеристик, вычисляется динамически из всех бонусов.
 */
class Stat extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected function casts(): array
    {
        return [
            'slug' => StatSlug::class,
        ];
    }

    /** Бонусы к данному показателю, предоставляемые классами персонажей. */
    public function classBonuses(): MorphMany
    {
        return $this->morphMany(ClassBonus::class, 'modifiable');
    }

    /** Бонусы к данному показателю, предоставляемые чертами. */
    public function featBonuses(): MorphMany
    {
        return $this->morphMany(FeatBonus::class, 'modifiable');
    }
}
