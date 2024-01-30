<?php

namespace Database\Seeders;

use App\Models\Sections;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sections::create([
            'name' => 'kids'
        ]);
        Sections::create([
            'name' => 'youth'
        ]);
        Sections::create([
            'name' => 'singles'
        ]);
        Sections::create([
            'name' => 'servants'
        ]);
        Sections::create([
            'name' => 'handmaids'
        ]);
        Sections::create([
            'name' => 'couples'
        ]);
    }
}
