<?php

namespace Database\Seeders\Feats;

use App\Enums\AbilitySlug;
use App\Enums\RarityName;
use App\Enums\StatSlug;
use App\Models\Ability;
use App\Models\Feat;
use App\Models\FeatBonus;
use App\Models\Rarity;
use App\Models\Skill;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class LegendaryFeatsSeeder extends Seeder
{
    public function run(): void
    {
        $legendary = Rarity::where('name', RarityName::Legendary)->firstOrFail();

        $feats = [
            [
                'name'        => 'Legendary Lumberjack',
                'description' => 'You get the Heavy Axe, a tool allowing you to fell a tree in a single swing! A MOD will provide it upon obtaining this feat, and replace it if lost. This item may not be lent or given to another player — doing so will result in a strike. (+1 to Strength, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Strength, 1],
                ],
            ],
            [
                'name'        => 'Legendary Miner',
                'description' => 'You get the Miner\'s Blessing, a powerful pickaxe that becomes better as it is used. A MOD will provide it upon obtaining this feat, and replace it if lost. This item may not be lent or given to another player — doing so will result in a strike. (+1 to Strength, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Strength, 1],
                ],
            ],
            [
                'name'        => 'Legendary Farmer',
                'description' => 'You get the Agricultural Abomination, with the ability to replant as you farm crops. A MOD will provide it upon obtaining this feat, and replace it if lost. This item may not be lent or given to another player — doing so will result in a strike. (+1 to Constitution, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Constitution, 1],
                ],
            ],
            [
                'name'        => 'Legendary Swordmaster',
                'description' => 'You gain the Caveman Sword, one that levels up with you! A MOD will provide it upon obtaining this feat, and replace it if lost. This item may not be lent or given to another player — doing so will result in a strike. (+1 to Strength, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Strength, 1],
                ],
            ],
            [
                'name'        => 'Legendary Protector',
                'description' => 'You gain +2 to your HP (MAX of 10). You gain the Protector Reaction from the Knight Class. (+1 to Constitution, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Constitution, 1],
                    ['stat',    StatSlug::HitPoints,       2],
                ],
            ],
            [
                'name'        => 'Legendary Fighter',
                'description' => 'You have excelled in your martial skills. Once per combat, you can attack twice in one turn. (+1 to Strength OR Dexterity, MAX of 20 — chosen on purchase)',
                'bonuses'     => [],
            ],
        ];

        foreach ($feats as $data) {
            $feat = Feat::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description'], 'rarity_id' => $legendary->id],
            );

            foreach ($data['bonuses'] as [$type, $slug, $value]) {
                $target = match ($type) {
                    'stat'    => Stat::where('slug', $slug)->firstOrFail(),
                    'skill'   => Skill::where('slug', $slug)->firstOrFail(),
                    'ability' => Ability::where('slug', $slug)->firstOrFail(),
                };

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
