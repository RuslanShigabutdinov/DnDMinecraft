<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RaritySeeder;
use Database\Seeders\FeatsSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            AlignmentSeeder::class,
            AbilitySeeder::class,
            SkillSeeder::class,
            StatSeeder::class,
            RaritySeeder::class,
            ClassesSeeder::class,
            FeatsSeeder::class,
        ]);
    }
}
