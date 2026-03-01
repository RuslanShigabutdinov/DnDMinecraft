<?php

namespace Database\Seeders\Classes;

use App\Enums\AbilitySlug;
use App\Enums\ActionType;
use App\Enums\SkillSlug;
use App\Enums\StatSlug;
use App\Models\Ability;
use App\Models\CharacterClass;
use App\Models\ClassAbility;
use App\Models\ClassBonus;
use App\Models\Skill;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class KnightSeeder extends Seeder
{
    public function run(): void
    {
        $knight = CharacterClass::firstOrCreate(
            ['name' => 'Knight'],
            ['description' => 'I have faced Death this Night, and called His Bluff. You are who others turn to when something goes wrong. The protectors, the rule makers, the driving force of the Empire. People place their trust in you, so you must prove them right.'],
        );

        // Stat bonuses: +3 AC, +3 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 3],
            [StatSlug::HitPoints,  3],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $knight->id, 'modifiable_type' => Stat::class, 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +1 Charisma, +2 Strength
        $abilityBonuses = [
            [AbilitySlug::Charisma, 1],
            [AbilitySlug::Strength, 2],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $knight->id, 'modifiable_type' => Ability::class, 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +2 Intimidation
        $skillBonuses = [
            [SkillSlug::Intimidation, 2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $knight->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Honour Code',
                'description' => 'This job isn\'t for everyone. Knights can\'t directly lie, in exchange they get a +5 to Insight.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Fortress',
                'description' => 'You stand for Justice. When you attack, should you gain advantage, you can forgo advantage to instead attack twice.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Protector',
                'description' => 'You are the Shield. If you are within 10 feet of an ally, you can throw yourself in front of your ally if they are attacked. If you do so, you gain Advantage against the attacker for your next attack. You can not use this for yourself.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Honor',
                'description' => 'A sword is a heavy burden. If you miss your attack, you can instead reroll your attack. You must use the new roll.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $knight->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
