<?php

namespace Database\Seeders;

use App\Models\Treasury;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreasurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('treasuries')->truncate();
        Treasury::factory(20)->create();
    }
}
