<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Superadmin',
            'email' => 'superadmin1@gmail.com',
            'password' => Hash::make('1234567890'),
        ]);

        DB::table('m_superadmin')->insert([
            'level_id' => 1,
            'user_id' => 3
        ]);
    }
}
