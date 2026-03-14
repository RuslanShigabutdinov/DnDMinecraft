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

class RareFeatsSeeder extends Seeder
{
    public function run(): void
    {
        $rare = Rarity::where('name', RarityName::Rare)->firstOrFail();

        $feats = [
            [
                'name'        => 'Aim for the Head',
                'description' => 'Before you attack with a ranged weapon, you may take -5 to your attack roll to deal double the damage.',
                'bonuses'     => [],
            ],
            [
                'name'        => 'Astute',
                'description' => 'You can add your intelligence modifier whenever rolling initiative. In combat, when you miss an attack roll, ability check, or saving throw, you can use your reaction to analyze your failure. Before the end of combat, the next time you try to perform said task, you gain advantage on your roll. You may only do this once per combat. (+1 to Intelligence, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Intelligence, 1],
                ],
            ],
            [
                'name'        => 'Second Chance',
                'description' => 'You are a coward at heart. If an attack was to hit you and drop you to 0, make them reroll. They must take the new roll. This can only be used once per combat. (+1 to Intelligence, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Intelligence, 1],
                ],
            ],
            [
                'name'        => 'Drunken Master',
                'description' => 'You may have a problem.. Whenever you drink, you gain a +1 to your attack rolls, but you roll at Disadvantage on Charisma rolls for the day! (Once Per Day) (+2 to Strength, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Strength, 2],
                ],
            ],
            [
                'name'        => 'Durable',
                'description' => 'You can use your Constitution modifier instead of your class AC (Max of +5). Once per combat, as a Reaction to getting hit, you can force the attacker to roll again, taking the lower roll. (+1 to Constitution, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Constitution, 1],
                ],
            ],
            [
                'name'        => 'Great Weapon Attack',
                'description' => 'Once per combat, should you roll a critical hit, you can use your bonus action to attack again, but you do not get to add any attack modifier to it. (+1 to Strength OR Dexterity, MAX of 20 — chosen on purchase)',
                'bonuses'     => [],
            ],
            [
                'name'        => 'Vital Sacrifice',
                'description' => 'Once per combat, you can sacrifice 2 HP to deal double damage on your next successful attack. (+1 to HP, MAX of 10)',
                'bonuses'     => [
                    ['stat', StatSlug::HitPoints, 1],
                ],
            ],
        ];

        foreach ($feats as $data) {
            $feat = Feat::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description'], 'rarity_id' => $rare->id],
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
