<?php

namespace Database\Seeders;

use Database\Seeders\Feats\ClassFeatsSeeder;
use Database\Seeders\Feats\CommonFeatsSeeder;
use Database\Seeders\Feats\LegendaryFeatsSeeder;
use Database\Seeders\Feats\RareFeatsSeeder;
use Database\Seeders\Feats\UncommonFeatsSeeder;
use Illuminate\Database\Seeder;

class FeatsSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CommonFeatsSeeder::class,
            UncommonFeatsSeeder::class,
            RareFeatsSeeder::class,
            LegendaryFeatsSeeder::class,
            ClassFeatsSeeder::class,
        ]);
    }
}
