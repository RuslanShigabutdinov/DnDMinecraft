<?php

namespace Database\Seeders;

use App\Enums\AbilitySlug;
use App\Models\Ability;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
{
    public function run(): void
    {
        $abilities = [
            ['name' => 'Strength',     'slug' => AbilitySlug::Strength],
            ['name' => 'Dexterity',    'slug' => AbilitySlug::Dexterity],
            ['name' => 'Constitution', 'slug' => AbilitySlug::Constitution],
            ['name' => 'Intelligence', 'slug' => AbilitySlug::Intelligence],
            ['name' => 'Wisdom',       'slug' => AbilitySlug::Wisdom],
            ['name' => 'Charisma',     'slug' => AbilitySlug::Charisma],
        ];

        foreach ($abilities as $ability) {
            Ability::firstOrCreate(['slug' => $ability['slug']], $ability);
        }
    }
}
