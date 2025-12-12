<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->truncate();
        Setting::create([
            'system_name' => 'الفرجاني',
            'address' => 'حلمية الزيتون',
            'phone' => '01128458999',
            'email' => 'VY3eD@example.com',
            'added_by' => 1,
            'updated_by' => 1,
            'com_code' => 1,
            'active' => 1,
            'general_alert' => '1'
        ]);
    }
}
