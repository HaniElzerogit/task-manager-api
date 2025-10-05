<?php

namespace Database\Seeders;

use App\Models\Catigory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CatigorySeeder extends Seeder
{

    public function run(): void
    {
        $catigories =
            [
                'Work',
                'Personal',
                'Projects',
                'Education',
                'Finance',
                'Health',
                'Fitness'
            ];
        foreach ($catigories as $catigory)
            Catigory::create(['name' => $catigory]);
    }
}
