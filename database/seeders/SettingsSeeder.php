<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        # Appearance
        \App\Models\Setting::create(['key'=>'dashboard_dark_mode','value'=>0]);
    }
}
