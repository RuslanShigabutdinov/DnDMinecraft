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

class BrawlerSeeder extends Seeder
{
    public function run(): void
    {
        $brawler = CharacterClass::firstOrCreate(
            ['name' => 'Brawler'],
            ['description' => 'If you wish to win, don\'t lose. Maybe a past soldier or a drunkard with experience, you are adept in fighting bare handed or with a weapon. Should anyone need a beatdown, maybe they should hunt you down.'],
        );

        // Stat bonuses: +1 AC, +3 HP
        $statBonuses = [
            [StatSlug::ArmorClass, 1],
            [StatSlug::HitPoints,  3],
        ];

        foreach ($statBonuses as [$slug, $value]) {
            $stat = Stat::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $brawler->id, 'modifiable_type' => Stat::class, 'modifiable_id' => $stat->id],
                ['value' => $value],
            );
        }

        // Ability bonuses: +2 Strength
        $abilityBonuses = [
            [AbilitySlug::Strength, 2],
        ];

        foreach ($abilityBonuses as [$slug, $value]) {
            $ability = Ability::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $brawler->id, 'modifiable_type' => Ability::class, 'modifiable_id' => $ability->id],
                ['value' => $value],
            );
        }

        // Skill bonuses: +2 Intimidation, +1 Acrobatics
        $skillBonuses = [
            [SkillSlug::Intimidation, 2],
            [SkillSlug::Acrobatics,   1],
        ];

        foreach ($skillBonuses as [$slug, $value]) {
            $skill = Skill::where('slug', $slug)->first();
            ClassBonus::firstOrCreate(
                ['class_id' => $brawler->id, 'modifiable_type' => Skill::class, 'modifiable_id' => $skill->id],
                ['value' => $value],
            );
        }

        // Special abilities
        $abilities = [
            [
                'name'        => 'Heavy Handed',
                'description' => 'Fighting is what you do. Using your fists instead of a weapon grants you an additional +1 for attack. You have advantage to grapple checks.',
                'action_type' => ActionType::Passive,
            ],
            [
                'name'        => 'Rush',
                'description' => 'Attack first, think later. Attack your opponent with a +4 to hit, but the next attack against you has advantage.',
                'action_type' => ActionType::BonusAction,
            ],
            [
                'name'        => 'Checked',
                'description' => 'Walk it off? No way. After an attack hits, you can attack your opponent, but roll with a -4 on your next attack.',
                'action_type' => ActionType::Reaction,
            ],
            [
                'name'        => 'Put \'em Up',
                'description' => 'Enter a guarded stance, gaining +4 AC for one turn and nullifying any advantage against you. If no attack deals damage to you in that time, regain +1 HP at the start of your next turn.',
                'action_type' => ActionType::OncePerCombat,
            ],
        ];

        foreach ($abilities as $ability) {
            ClassAbility::firstOrCreate(
                ['class_id' => $brawler->id, 'name' => $ability['name']],
                ['description' => $ability['description'], 'action_type' => $ability['action_type']],
            );
        }
    }
}
