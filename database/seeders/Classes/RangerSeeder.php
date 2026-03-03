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

class RangerSeeder extends Seeder
{
    public function run(): void
    {
        $ranger = CharacterClass::firstOrCreate(
            ['name' => 'Ranger'],
            ['description' => 'The Forest forgets the fallen. There are those who seek refuge in the stone jungles of civilization, but you find comfort in those outside, comfort in your mission to preserve what remains in the woods. You are the survivor, and you ensure no one else will if they step into the woods.'],
        );

        // Stat bonuses: +2 AC, +1 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 2],
            [StatSlug::HitPoints,  1],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $ranger->id, 'modifiable_type' => $stat->getMorphClass(), 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +2 Dexterity, +3 Wisdom
        $abilityBonuses = [
            [AbilitySlug::Dexterity, 2],
            [AbilitySlug::Wisdom,    3],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $ranger->id, 'modifiable_type' => $ability->getMorphClass(), 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +2 Perception
        $skillBonuses = [
            [SkillSlug::Perception, 2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $ranger->id, 'modifiable_type' => $skill->getMorphClass(), 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Favored Enemy',
                'description' => 'Tracking is an art. You are the go-to for finding someone. When you Investigate an area, you gain a +5 to Investigation if it is related to the creature you\'re dedicated to tracking.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Sharpshooter',
                'description' => 'They will not escape you. You can forgo your Action to charge your weapon to gain advantage on your next attack with an additional +3 to your attack.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Return',
                'description' => 'Right back at them! If an ally in range is attacked, you may make an attack roll against their attacker.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Denied',
                'description' => 'Retreat isn\'t an option. After you land an attack, you can choose that the damage dealt prevents your opponent from moving for one turn, allowing you to roll your next attack with Advantage.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $ranger->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
