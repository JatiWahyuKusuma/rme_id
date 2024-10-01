<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'level_id' => 1,
                'kode_level' => 'SPRADMN',
                'nama_level'=> 'Super Administrator',
            ],
            [
                'level_id' => 2,
                'kode_level' => 'ADMN',
                'nama_lev'=> 'Administrator',
            ],

        ];

        DB::table('m_level')->insert($data);
    }
}
