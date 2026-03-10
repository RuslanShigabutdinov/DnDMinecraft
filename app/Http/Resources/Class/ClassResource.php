<?php

namespace App\Http\Resources\Class;

use App\Http\Resources\Bonus\BonusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'bonuses'     => $this->when($this->relationLoaded('bonuses'), fn() => [
                'stats'     => BonusResource::collection($this->bonuses->where('modifiable_type', 'stat')),
                'abilities' => BonusResource::collection($this->bonuses->where('modifiable_type', 'ability')),
                'skills'    => BonusResource::collection($this->bonuses->where('modifiable_type', 'skill')),
            ]),
        ];
    }
}
