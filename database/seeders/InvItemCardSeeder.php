<?php

namespace Database\Seeders;

use App\Models\InvItemCard;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvItemCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inv_item_cards')->truncate();
        InvItemCard::factory(20)->create();
    }
}
    