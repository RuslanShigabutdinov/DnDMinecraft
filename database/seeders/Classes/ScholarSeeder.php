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

class ScholarSeeder extends Seeder
{
    public function run(): void
    {
        $scholar = CharacterClass::firstOrCreate(
            ['name' => 'Scholar'],
            ['description' => 'Knowledge is power, and my pen is my sword. Research is key to progress, and you are one to always seek it. You are typically the first to find the lore needed to save the day, or perhaps you found the formula that creates the perfect medicine. The possibilities are endless for those such as you. The only limit is your imagination and what is at your fingertips.'],
        );

        // Stat bonuses: +1 AC, +2 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 1],
            [StatSlug::HitPoints,  2],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $scholar->id, 'modifiable_type' => $stat->getMorphClass(), 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +2 Intelligence, +1 Wisdom
        $abilityBonuses = [
            [AbilitySlug::Intelligence, 2],
            [AbilitySlug::Wisdom,       1],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $scholar->id, 'modifiable_type' => $ability->getMorphClass(), 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +2 Insight, +3 Investigation
        $skillBonuses = [
            [SkillSlug::Insight,       2],
            [SkillSlug::Investigation, 3],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $scholar->id, 'modifiable_type' => $skill->getMorphClass(), 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Academic Prowess',
                'description' => 'Progress arrives as inevitably as the sun rises. As a person of knowledge, you can research the secrets of this world. Choose a subject to receive information on and talk to a mod. Maybe even... invent something.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Diplomat',
                'description' => 'Your higher education allures to a pragmatic approach, persuasion checks aimed at disarming conflict not only gain advantage but you may also use a secondary separate check as a bonus action.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Flash of Ingenuity',
                'description' => '"Hey, I\'ve read about this!" When your enemy uses an attack or ability that you have witnessed/researched before, you can either gain advantage on your next attack, or give the advantage to an ally.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Abandon',
                'description' => 'Ed Gads! Should you find yourself in a fight, you should scramble post haste! Throw down a smoke bomb. Allowing you to disengage.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $scholar->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
