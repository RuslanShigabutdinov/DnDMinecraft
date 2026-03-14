<?php

namespace Database\Seeders\Feats;

use App\Enums\AbilitySlug;
use App\Enums\RarityName;
use App\Enums\SkillSlug;
use App\Enums\StatSlug;
use App\Models\Ability;
use App\Models\Feat;
use App\Models\FeatBonus;
use App\Models\Rarity;
use App\Models\Skill;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class CommonFeatsSeeder extends Seeder
{
    public function run(): void
    {
        $common = Rarity::where('name', RarityName::Common)->firstOrFail();

        $feats = [
            [
                'name'        => 'Alert',
                'description' => 'You have trained your senses to new limits. When rolling initiative, you may add your perception modifier. Immediately after rolling initiative, you may also swap your initiative with that of a conscious ally.',
                'bonuses'     => [],
            ],
            [
                'name'        => 'Shield Expert',
                'description' => 'Let your shield take the beating for you. When wielding a shield, add +2 to your AC. You have advantage on strength saving throws against being pushed or grappled.',
                'bonuses'     => [
                    ['stat', StatSlug::ArmorClass, 2],
                ],
            ],
            [
                'name'        => 'Duelist',
                'description' => 'A shield would simply lower your grace. When attacking with a weapon, if your off-hand is empty, add +2 to your attack rolls. You have advantage on dexterity saving throws.',
                'bonuses'     => [],
            ],
            [
                'name'        => 'True Shot',
                'description' => 'Your aim strikes true, mostly. When making an attack using a ranged weapon, add +1 to your attack roll.',
                'bonuses'     => [],
            ],
            [
                'name'        => 'Dual Wielder',
                'description' => 'Why use a shield when you can do double the stabbing? In combat, you gain +1 to your attack rolls, and gain +1 to your AC. You may not dual wield ranged weapons.',
                'bonuses'     => [
                    ['stat', StatSlug::ArmorClass, 1],
                ],
            ],
            [
                'name'        => 'Healer',
                'description' => 'You have learned how to care for others in a medical sense. You know as much as a Nurse would, and can half the speed in which someone heals. (+2 to Medicine, MAX of +10 Total)',
                'bonuses'     => [
                    ['skill', SkillSlug::Medicine, 2],
                ],
            ],
            [
                'name'        => 'Observant',
                'description' => 'You know how to read lips, and have great attention to detail. (+5 to Perception, MAX of +10 Total)',
                'bonuses'     => [
                    ['skill', SkillSlug::Perception, 5],
                ],
            ],
            [
                'name'        => 'Ventriloquist',
                'description' => 'You know how to produce sounds and words without moving your lips. They do sound like your own voice, however. (+1 to Constitution, MAX of 20)',
                'bonuses'     => [
                    ['ability', AbilitySlug::Constitution, 1],
                ],
            ],
            [
                'name'        => 'Spy',
                'description' => 'You are an expert in sneaking around and finding things! Lets just hope you don\'t get caught… (+2 to Stealth, +2 Investigation, MAX of +10 Total)',
                'bonuses'     => [
                    ['skill', SkillSlug::Stealth,       2],
                    ['skill', SkillSlug::Investigation, 2],
                ],
            ],
        ];

        foreach ($feats as $data) {
            $feat = Feat::firstOrCreate(
                ['name' => $data['name']],
                ['description' => $data['description'], 'rarity_id' => $common->id],
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
