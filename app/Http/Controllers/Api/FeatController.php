<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    Rarity,
    Feat,
    FeatBonus,
};
class FeatController extends Controller
{
    public function listRarities() {
        $rarities = Rarity::with('feats')->get();
        return response()->json($rarities);
    }
}
