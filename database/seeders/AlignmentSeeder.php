<?php

namespace Database\Seeders;

use App\Models\Alignment;
use Illuminate\Database\Seeder;

class AlignmentSeeder extends Seeder
{
    public function run(): void
    {
        $alignments = [
            'Lawful Good',
            'Neutral Good',
            'Chaotic Good',
            'Lawful Neutral',
            'True Neutral',
            'Chaotic Neutral',
            'Lawful Evil',
            'Neutral Evil',
            'Chaotic Evil',
        ];

        foreach ($alignments as $name) {
            Alignment::firstOrCreate(['name' => $name]);
        }
    }
}
