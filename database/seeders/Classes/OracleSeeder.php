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

class OracleSeeder extends Seeder
{
    public function run(): void
    {
        $oracle = CharacterClass::firstOrCreate(
            ['name' => 'Oracle'],
            ['description' => 'Time is not set, and Fate is not stone, if we act upon this right. The Paladins have grace, and Knights have Honor, but you alone are given a special gift. Cursed with visions that alert you to what may come, you now have the responsibility to warn those before it\'s too late. Can you truly decide who may die, if you are not prepared with what is handed down to you?'],
        );

        // Stat bonuses: +1 AC, +2 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 1],
            [StatSlug::HitPoints,  2],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $oracle->id, 'modifiable_type' => Stat::class, 'modifiable_id' => $stat->id],
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
                ['class_id' => $oracle->id, 'modifiable_type' => Ability::class, 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +3 Insight, +2 Persuasion
        $skillBonuses = [
            [SkillSlug::Insight,    3],
            [SkillSlug::Persuasion, 2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $oracle->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Clouded Vision',
                'description' => 'There will always be a cost. Periodically, you can seek guidance from a divine patron and receive a vague vision that may aid you or someone else. This will be handed down by a mod. But be wary, as some visions may be there to trick you, and not all who answer your call have your interests at heart.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Phantom',
                'description' => 'Those long gone aid your fight. Roll an Insight check, and learn of an opponent\'s weakness (for PCs, it will be something of their choosing) and gain advantage on your next attack.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Saw That Coming',
                'description' => 'Could you have been more obvious? Raise or lower a skill check by 2, before the roll.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Diviner',
                'description' => 'Truth reaches you before others. Once per combat, you may decide to reroll any of your rolls, taking the highest result.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $oracle->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
