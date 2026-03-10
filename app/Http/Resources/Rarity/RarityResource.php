<?php

namespace App\Http\Resources\Rarity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Feat\FeatResource;

class RarityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'point_cost'  => $this->point_cost,
            'feats'       => FeatResource::collection($this->whenLoaded('feats')),
        ];
    }
}
