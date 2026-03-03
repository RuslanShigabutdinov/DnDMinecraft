<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassBonusResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name'  => $this->modifiable->name,
            'slug'  => $this->modifiable->slug,
            'value' => $this->value,
        ];
    }
}
