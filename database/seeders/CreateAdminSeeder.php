<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        DB::table('admins')->truncate();
        $admins = [
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('123456789'),
                'username' => 'admin',
                'active' => 1,
                'com_code' => 1
            ],
            [
                'name' => 'Second Admin',
                'email' => 'adminv2@admin.com',
                'password' => Hash::make('123456789'),
                'username' => 'adminv2',
                'active' => 1,
                'com_code' => 2
            ]
        ];
        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
