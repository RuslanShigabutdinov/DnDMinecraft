<?php

namespace Database\Seeders;

use App\Enums\AbilitySlug;
use App\Enums\SkillSlug;
use App\Models\Ability;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $abilityIds = Ability::pluck('id', 'slug');

        $skills = [
            // Strength
            ['name' => 'Athletics',       'slug' => SkillSlug::Athletics,     'ability' => AbilitySlug::Strength],

            // Dexterity
            ['name' => 'Acrobatics',      'slug' => SkillSlug::Acrobatics,    'ability' => AbilitySlug::Dexterity],
            ['name' => 'Sleight of Hand', 'slug' => SkillSlug::SleightOfHand, 'ability' => AbilitySlug::Dexterity],
            ['name' => 'Stealth',         'slug' => SkillSlug::Stealth,       'ability' => AbilitySlug::Dexterity],

            // Intelligence
            ['name' => 'Arcana',          'slug' => SkillSlug::Arcana,        'ability' => AbilitySlug::Intelligence],
            ['name' => 'History',         'slug' => SkillSlug::History,       'ability' => AbilitySlug::Intelligence],
            ['name' => 'Investigation',   'slug' => SkillSlug::Investigation, 'ability' => AbilitySlug::Intelligence],
            ['name' => 'Nature',          'slug' => SkillSlug::Nature,        'ability' => AbilitySlug::Intelligence],
            ['name' => 'Religion',        'slug' => SkillSlug::Religion,      'ability' => AbilitySlug::Intelligence],

            // Wisdom
            ['name' => 'Animal Handling', 'slug' => SkillSlug::AnimalHandling, 'ability' => AbilitySlug::Wisdom],
            ['name' => 'Insight',         'slug' => SkillSlug::Insight,        'ability' => AbilitySlug::Wisdom],
            ['name' => 'Medicine',        'slug' => SkillSlug::Medicine,       'ability' => AbilitySlug::Wisdom],
            ['name' => 'Perception',      'slug' => SkillSlug::Perception,     'ability' => AbilitySlug::Wisdom],
            ['name' => 'Survival',        'slug' => SkillSlug::Survival,       'ability' => AbilitySlug::Wisdom],

            // Charisma
            ['name' => 'Deception',       'slug' => SkillSlug::Deception,    'ability' => AbilitySlug::Charisma],
            ['name' => 'Intimidation',    'slug' => SkillSlug::Intimidation, 'ability' => AbilitySlug::Charisma],
            ['name' => 'Performance',     'slug' => SkillSlug::Performance,  'ability' => AbilitySlug::Charisma],
            ['name' => 'Persuasion',      'slug' => SkillSlug::Persuasion,   'ability' => AbilitySlug::Charisma],
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(
                ['slug' => $skill['slug']],
                ['name' => $skill['name'], 'ability_id' => $abilityIds[$skill['ability']->value]]
            );
        }
    }
}
