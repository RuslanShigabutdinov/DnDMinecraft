<?php

namespace Database\Seeders\Classes;

use App\Enums\AbilitySlug;
use App\Enums\ActionType;
use App\Enums\SkillSlug;
use App\Models\Ability;
use App\Models\CharacterClass;
use App\Models\ClassAbility;
use App\Models\ClassBonus;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class BardSeeder extends Seeder
{
    public function run(): void
    {
        $bard = CharacterClass::firstOrCreate(
            ['name' => 'Bard'],
            ['description' => 'We may fail, but at least we won\'t be bored! It is your job to entertain the masses! This is up to you, be it a simple musician, a support in battle or something else!'],
        );

        // Ability bonuses: +2 Charisma, +1 Dexterity
        $abilityBonuses = [
            [AbilitySlug::Charisma,  2],
            [AbilitySlug::Dexterity, 1],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $bard->id, 'modifiable_type' => Ability::class, 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +2 Performance, +2 Persuasion, +2 Acrobatics, +2 Insight
        $skillBonuses = [
            [SkillSlug::Performance, 2],
            [SkillSlug::Persuasion,  2],
            [SkillSlug::Acrobatics,  2],
            [SkillSlug::Insight,     2],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $bard->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Sing Song',
                'description' => 'All love to hear it. You will be accepted into any Inn in exchange for your musical expertise, as well as earn coin. You can use your song to distract an enemy to escape an encounter before it begins with a Performance Check of DC 14.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Fiddle',
                'description' => 'Play to your hearts content! Once per turn your music pushes someone to excellence, giving them an advantage on their next attack.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Sour Note',
                'description' => 'Yeesh! If an ally you can see is attacked, you may use a reaction to play a sour note, throwing off the flow of battle and causing the attack to roll at a -2.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Inspired!',
                'description' => 'A poem a day. Inspire yourself or your allies with your bravest quote, gaining a +1 to attack. If you are in a group, all allies gain this effect for 3 attacks.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $bard->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
