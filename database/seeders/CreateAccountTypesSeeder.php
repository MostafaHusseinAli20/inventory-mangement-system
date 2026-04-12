<?php

namespace Database\Seeders;

use App\Models\AccountType;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('account_types')->truncate();
        $admin = Admin::first();
        $accounts = [
            [
                'name' => 'رأس مال',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 0,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'مورد',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 1,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'عميل',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 1,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'مندوب',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 1,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'موظف',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 1,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'بنكي',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 0,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'مصروفات',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 0,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'قسم داخلي',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 1,
                'com_code' => $admin?->com_code
            ],
            [
                'name' => 'عام',
                'date' => now(),
                'added_by' => $admin?->id,
                'relatediternalaccounts' => 1,
                'com_code' => $admin?->com_code
            ]
        ];

        foreach($accounts as $account) {
            AccountType::create($account);
        }
    }
}
