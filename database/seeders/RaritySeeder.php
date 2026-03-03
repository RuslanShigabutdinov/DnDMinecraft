<?php

namespace Database\Seeders;

use App\Models\Rarity;
use Illuminate\Database\Seeder;
use App\Enums\RarityName;

class RaritySeeder extends Seeder
{
    public function run(): void
    {
        $rarities = [
            ['name' => RarityName::Common,    'point_cost' => 50],
            ['name' => RarityName::Uncommon,  'point_cost' => 75],
            ['name' => RarityName::Rare,      'point_cost' => 100],
            ['name' => RarityName::Legendary, 'point_cost' => 150],
        ];

        foreach ($rarities as $rarity) {
            Rarity::firstOrCreate(['name' => $rarity['name']], $rarity);
        }
    }
}
