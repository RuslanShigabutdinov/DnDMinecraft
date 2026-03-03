<?php

namespace App\Http\Resources;

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
                'stats'     => ClassBonusResource::collection($this->bonuses->where('modifiable_type', 'stat')),
                'abilities' => ClassBonusResource::collection($this->bonuses->where('modifiable_type', 'ability')),
                'skills'    => ClassBonusResource::collection($this->bonuses->where('modifiable_type', 'skill')),
            ]),
        ];
    }
}
