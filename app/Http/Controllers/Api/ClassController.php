<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClassResource;
use App\Models\CharacterClass;

class ClassController extends Controller
{
    public function list()
    {
        $classes = CharacterClass::with([
            'bonuses.modifiable',
            'abilities',
        ])->get();

        return ClassResource::collection($classes);
    }
}
