<?php

namespace Database\Seeders\Feats;

use App\Enums\RarityName;
use App\Enums\StatSlug;
use App\Models\Feat;
use App\Models\FeatBonus;
use App\Models\Rarity;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class UncommonFeatsSeeder extends Seeder
{
    public function run(): void
    {
        $uncommon = Rarity::where('name', RarityName::Uncommon)->firstOrFail();

        $feats = [
            [
                'name'        => 'Tough',
                'description' => 'You\'ve learned to endure the roughest of beatings. Your hit points increase by 2 (MAX of 10).',
                'bonuses'     => [
                    ['stat', StatSlug::HitPoints, 2],
                ],
            ],
            [
                'name'        => 'Savage Attacker',
                'description' => 'You won\'t go down easy. When an attack hits, once per combat, you can attack back as a reaction. You gain a point of Exhaustion at the end of the fight.',
                'bonuses'     => [],
            ],
        ];

        foreach ($feats as $data) {
            $feat = Feat::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description'], 'rarity_id' => $uncommon->id],
            );

            foreach ($data['bonuses'] as [$type, $slug, $value]) {
                $target = Stat::where('slug', $slug)->firstOrFail();

                FeatBonus::firstOrCreate(
                    [
                        'feat_id'         => $feat->id,
                        'modifiable_type' => $target->getMorphClass(),
                        'modifiable_id'   => $target->id,
                    ],
                    ['value' => $value],
                );
            }
        }
    }
}
