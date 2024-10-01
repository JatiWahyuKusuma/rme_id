<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $data = [
            [
                'opco_id' => 1,
                'kode_opco' => 'TBN',
                'nama_opco'=> 'GHOPO Tuban',
            ],
            [
                'opco_id' => 2,
                'kode_opco' => 'SG',
                'nama_opco'=> 'SG Rembang',
            ],

        ];

        DB::table('m_opco')->insert($data);
    }
}
