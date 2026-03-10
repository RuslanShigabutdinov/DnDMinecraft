<?php

namespace App\Http\Resources\Bonus;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BonusResource extends JsonResource
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
