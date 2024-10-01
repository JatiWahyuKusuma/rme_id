<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'admin_id' => 1,
                'level_id' => 2,
                'opco_id' => 1,
                'nama' => 'Admin GHOPO',
                'email' => 'adminghopo@gmail.com',
                'password' => Hash::make('adminghopo123'),
            ],
            [
                'admin_id' => 2,
                'level_id' => 2,
                'opco_id' => 2,
                'nama' => 'Admin SG',
                'email' => 'adminsg@gmail.com',
                'password' => Hash::make('adminsg123'),
            ],

        ];

        DB::table('m_admin')->insert($data);
    }
}
