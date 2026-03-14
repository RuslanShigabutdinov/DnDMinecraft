<?php

namespace Database\Seeders\Feats;

use App\Enums\AbilitySlug;
use App\Enums\RarityName;
use App\Enums\SkillSlug;
use App\Enums\StatSlug;
use App\Models\Ability;
use App\Models\CharacterClass;
use App\Models\Feat;
use App\Models\FeatBonus;
use App\Models\Rarity;
use App\Models\Skill;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class ClassFeatsSeeder extends Seeder
{
    public function run(): void
    {
        $common = Rarity::where('name', RarityName::Common)->firstOrFail();

        $classFeatData = [
            'Rogue' => [
                [
                    'name'        => 'Poison Savvy',
                    'description' => 'You understand toxins, their effects, and how they are commonly applied. You can recognize signs of poisoning and know how substances are typically concealed or delivered. (+2 to Investigation, MAX of +10 Total)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Investigation, 2],
                    ],
                ],
            ],
            'Brawler' => [
                [
                    'name'        => 'Tavern Veteran',
                    'description' => 'Drinking is your pastime, and you\'ve been in many fights. If you find yourself in a tavern brawl, you can now use improvised weapons (chairs, tables, etc) with your Heavy Handed ability! (+2 to Strength, MAX of 20)',
                    'bonuses'     => [
                        ['ability', AbilitySlug::Strength, 2],
                    ],
                ],
            ],
            'Bard' => [
                [
                    'name'        => 'Silver Tongue',
                    'description' => 'You have found a way to get out of sticky situations. Gain +3 to Persuasion OR Deception (chosen on purchase).',
                    'bonuses'     => [],
                ],
            ],
            'Ranger' => [
                [
                    'name'        => 'Silent Draw',
                    'description' => 'You have learned how to be the predator. You draw your weapon with no sound. (+2 to Stealth, MAX of +10)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Stealth, 2],
                    ],
                ],
                [
                    'name'        => 'Field Healing',
                    'description' => 'You are used to the woods and have listened to the moss. Should someone need your aid in healing, you can fix someone up enough until they can be transferred. (+2 to Medicine, MAX of +10)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Medicine, 2],
                    ],
                ],
            ],
            'Knight' => [
                [
                    'name'        => 'Noble Duel',
                    'description' => 'If you are in melee range, impose disadvantage on any attack targeting an ally other than yourself.',
                    'bonuses'     => [],
                ],
            ],
            'Paladin' => [
                [
                    'name'        => 'Devoted',
                    'description' => 'You have been gifted by the Gods the ability to sense when someone of the opposite alignment is within your range (you must roll an Insight Check to confirm in roleplay). You may then gain advantage on your first attack in combat.',
                    'bonuses'     => [],
                ],
                [
                    'name'        => 'Tank',
                    'description' => 'You are not someone to mess with. (+2 to Strength)',
                    'bonuses'     => [
                        ['ability', AbilitySlug::Strength, 2],
                    ],
                ],
            ],
            'Medic' => [
                [
                    'name'        => 'Calming Presence',
                    'description' => 'You can stay calm in a tense situation, and help others stay calm too. Should your patient be in critical condition, you can save them from the brink. You gain an additional +1 to your HP Charge, for a total of 4 charges. (+2 to Charisma, MAX of +10)',
                    'bonuses'     => [
                        ['ability', AbilitySlug::Charisma, 2],
                    ],
                ],
            ],
            'Scholar' => [
                [
                    'name'        => 'Academic',
                    'description' => 'You are a researcher after all. Select a skill. If you make a skill check using that skill, roll a 1d6 and add that to your roll.',
                    'bonuses'     => [],
                ],
            ],
            'Oracle' => [
                [
                    'name'        => 'Confessor of Truths',
                    'description' => 'You are able to decipher lies from truth much easier than most, almost on par with that of a Knight. (+2 to Insight, MAX of +10)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Insight, 2],
                    ],
                ],
                [
                    'name'        => 'Forbidden',
                    'description' => 'Some futures require you to only watch, meaning you need to stay out of sight. (+2 to Stealth, MAX of +10)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Stealth, 2],
                    ],
                ],
            ],
            'Chef' => [
                [
                    'name'        => 'Amuse-Bouche',
                    'description' => 'You can make almost any sound come out of someone\'s mouth by food alone… Almost… (+3 to Persuasion, MAX of +10)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Persuasion, 3],
                    ],
                ],
                [
                    'name'        => 'Autopsy',
                    'description' => 'You have butchered enough animals to be able to identify the way someone has died, and give them a proper resting place in pieces. (+2 to Medicine)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Medicine, 2],
                    ],
                ],
                [
                    'name'        => 'Soul Food',
                    'description' => 'The way one reacts to food is a good teller on how that person is. When gathering information, you gain a +2 to your skill checks against someone as long as they are eating your food. (+2 to Insight)',
                    'bonuses'     => [
                        ['skill', SkillSlug::Insight, 2],
                    ],
                ],
            ],
        ];

        foreach ($classFeatData as $className => $feats) {
            $class = CharacterClass::where('name', $className)->firstOrFail();

            foreach ($feats as $data) {
                $feat = Feat::firstOrCreate(
                    ['name' => $data['name']],
                    [
                        'description' => $data['description'],
                        'rarity_id'   => $common->id,
                        'class_id'    => $class->id,
                    ],
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
}
