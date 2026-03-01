<?php

namespace Database\Seeders;

use App\Enums\StatSlug;
use App\Models\Stat;
use Illuminate\Database\Seeder;

class StatSeeder extends Seeder
{
    public function run(): void
    {
        $stats = [
            ['name' => 'Armor Class',        'slug' => StatSlug::ArmorClass],
            ['name' => 'Initiative',         'slug' => StatSlug::Initiative],
            ['name' => 'Hit Points',         'slug' => StatSlug::HitPoints],
            ['name' => 'Passive Perception', 'slug' => StatSlug::PassivePerception],
            ['name' => 'Passive Insight',    'slug' => StatSlug::PassiveInsight],
        ];

        foreach ($stats as $stat) {
            Stat::firstOrCreate(['slug' => $stat['slug']], $stat);
        }
    }
}
