<?php

namespace Database\Seeders;

use App\Models\SalesMatrialType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalesMatrialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sales_matrial_types')->truncate();
        SalesMatrialType::factory(20)->create();
    }
}
