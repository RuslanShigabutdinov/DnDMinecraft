<?php

namespace Database\Seeders;

use Database\Seeders\Classes\BardSeeder;
use Database\Seeders\Classes\BrawlerSeeder;
use Database\Seeders\Classes\ChefSeeder;
use Database\Seeders\Classes\KnightSeeder;
use Database\Seeders\Classes\MedicSeeder;
use Database\Seeders\Classes\OracleSeeder;
use Database\Seeders\Classes\PaladinSeeder;
use Database\Seeders\Classes\RangerSeeder;
use Database\Seeders\Classes\RogueSeeder;
use Database\Seeders\Classes\ScholarSeeder;
use Illuminate\Database\Seeder;

class ClassesSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ScholarSeeder::class,
            RogueSeeder::class,
            BrawlerSeeder::class,
            BardSeeder::class,
            PaladinSeeder::class,
            RangerSeeder::class,
            KnightSeeder::class,
            MedicSeeder::class,
            OracleSeeder::class,
            ChefSeeder::class,
        ]);
    }
}
