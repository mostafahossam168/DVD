<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settingsJson = file_get_contents(storage_path('settings.json'));

        $settings = json_decode($settingsJson, true);

        if ($settings) {
            foreach ($settings as $key => $value) {
                setting([$key => $value])->save();
            }
        }
    }
}