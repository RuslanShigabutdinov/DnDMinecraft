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

class RogueSeeder extends Seeder
{
    public function run(): void
    {
        $rogue = CharacterClass::firstOrCreate(
            ['name' => 'Rogue'],
            ['description' => 'Some Men prefer the darkness even though their deeds are good. Be it a spy, a mercenary or bandit, you are a sneaky person! You are the go to if something needs to be stolen, someone needs killed, or broken into somewhere!'],
        );

        // Stat bonuses: +1 AC, +2 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 1],
            [StatSlug::HitPoints,  2],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $rogue->id, 'modifiable_type' => Stat::class, 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +2 Dexterity
        $abilityBonuses = [
            [AbilitySlug::Dexterity, 2],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $rogue->id, 'modifiable_type' => Ability::class, 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +3 Stealth, +3 Sleight of Hand, +2 Investigation
        $skillBonuses = [
            [SkillSlug::Stealth,       3],
            [SkillSlug::SleightOfHand, 3],
            [SkillSlug::Investigation, 2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $rogue->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Silent but Deadly',
                'description' => 'An Assassin strikes without a sound. You make no noise when walking, and can not be perceived by sound.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Sneak Attack',
                'description' => 'You are a very sneaky person. By using a distraction (or other method), you have now gained Advantage to your roll, and, if you hit, deal double damage.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Evade',
                'description' => 'You are hard to catch! You use peoples perception against them! You may roll stealth to hide yourself when an ally attacks.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Misdirection',
                'description' => 'Look over there! At the loss of an item, you can use Hide to gain Advantage on your next Attack. (You must lose a real In-Game item)',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $rogue->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
