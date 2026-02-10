<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stages = [
            ['name' => 'المرحله الاعداديه عربى'],
            ['name' => 'المرحله الاعداديه لغات'],
            ['name' => 'المرحله الثانويه عربى'],
            ['name' => 'المرحله الثانويه لغات'],
            ['name' => 'المرحله الثانويه بكالوريا عربي'],
            ['name' => 'المرحله الثانويه بكالوريا لغات'],
        ];


        foreach ($stages as $stage) {
            Stage::create($stage);
        }
    }
}
