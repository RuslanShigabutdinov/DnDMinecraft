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

class MedicSeeder extends Seeder
{
    public function run(): void
    {
        $medic = CharacterClass::firstOrCreate(
            ['name' => 'Medic'],
            ['description' => 'To heal those close, we must mend what is broken, be it bones, or the pain within. To do what you do is a selfless job, avoiding fights to save those who do raise their wills. Be your healing ability seen as more religious, or simply science, your job is what keeps the Empire from drowning in blood.'],
        );

        // Stat bonuses: +2 AC, +1 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 2],
            [StatSlug::HitPoints,  1],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $medic->id, 'modifiable_type' => Stat::class, 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +2 Charisma
        $abilityBonuses = [
            [AbilitySlug::Charisma, 2],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $medic->id, 'modifiable_type' => Ability::class, 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +4 Medicine, +2 Perception
        $skillBonuses = [
            [SkillSlug::Medicine,   4],
            [SkillSlug::Perception, 2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $medic->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Natural Alchemist',
                'description' => 'Plant & herbal remedies come easy to you. You can store three charges of +1 HP potions or salves on you, renewed per day. If you have any missing HP, you instead have to focus on resting and relaxing before you can refill your stash.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Harmless',
                'description' => 'See no evil, do no evil. As a medical professional, you can choose to disengage from battle, taking one of the wounded with you.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Quick Salve',
                'description' => 'You can\'t die just yet. When an ally nearby suffers a critical attack, you can use one of your HP charges to heal your ally, negating the critical hit.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Broken',
                'description' => 'Just slap some duct tape on there. Upon taking lethal damage, you\'re able to bring someone back from the brink and into the fight. Revive one player with 1 HP.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $medic->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
