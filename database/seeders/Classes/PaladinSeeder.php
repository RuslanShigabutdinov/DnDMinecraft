<?php

namespace Database\Seeders\Classes;

use App\Enums\ActionType;
use App\Enums\SkillSlug;
use App\Enums\StatSlug;
use App\Models\CharacterClass;
use App\Models\ClassAbility;
use App\Models\ClassBonus;
use App\Models\Skill;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class PaladinSeeder extends Seeder
{
    public function run(): void
    {
        $paladin = CharacterClass::firstOrCreate(
            ['name' => 'Paladin'],
            ['description' => 'Pick a God and Pray, because you will be meeting mine soon. You are the devout, those who serve one of the Gods through your service. This comes through prophecies, opportunities and challenges that will require you to steel your faith.'],
        );

        // Stat bonuses: +3 AC, +2 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 3],
            [StatSlug::HitPoints,  2],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $paladin->id, 'modifiable_type' => Stat::class, 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +2 Insight, +3 Medicine
        $skillBonuses = [
            [SkillSlug::Insight,  2],
            [SkillSlug::Medicine, 3],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $paladin->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Divine Intervention',
                'description' => 'The Gods are fair. Should you pray to the gods, there is a chance they may answer your prayer! Roll a d100. If it is below 20, the Gods will bless you with their divine favor. Once per Day.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Smite',
                'description' => 'You shall never falter. Utter a prayer from your God, and give yourself an additional +1 to attack. If you are attacking someone of the opposite alignment, you get an additional +2, for a total of +3.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Aura',
                'description' => 'The devout are rewarded. If an attack is meant to drop you below 2 HP, your divine energy will heal you by damage dealt. However, this will give you a point of Exhaustion.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Protection',
                'description' => 'You shall not harm another. You can ready yourself to defend against the next attack, raising your AC by an additional +3. You may also put yourself on the line, guarding the next attack that would come to an ally.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $paladin->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
