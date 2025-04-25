<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubkriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'subkriteria_id' => 1,
                'kriteria_id' => 1,
                'nama_subkriteria' => "< 5 Tahun",
                'bobot_subkriteria' => 4,
            ],
            [
                'subkriteria_id' => 2,
                'kriteria_id' => 1,
                'nama_subkriteria' => " ≤ 15 Tahun",
                'bobot_subkriteria' => 3,
            ],
            [
                'subkriteria_id' => 3,
                'kriteria_id' => 1,
                'nama_subkriteria' => "≤ 30 Tahun",
                'bobot_subkriteria' => 2,
            ],
            [
                'subkriteria_id' => 4,
                'kriteria_id' => 1,
                'nama_subkriteria' => "> 30 Tahun",
                'bobot_subkriteria' => 1,
            ],
        ];
        DB::table('subkriteria')->insert($data);
    }
}
