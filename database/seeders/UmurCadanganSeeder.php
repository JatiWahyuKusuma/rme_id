<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UmurCadanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = Carbon::now()->year;

        $cadangans = DB::table('m_cadangan_bb')->get();

        $data = [];

        foreach ($cadangans as $cadangan) {
            $umurCadanganThn = $cadangan->umur_cadangan_thn;
            $sisaTahun = $currentYear + $umurCadanganThn;


            if ($umurCadanganThn < 5) {
                $status = 'Critical';
            } elseif ($umurCadanganThn <= 15) {
                $status = 'Prioritas 1';
            } elseif ($umurCadanganThn <= 30) {
                $status = 'Prioritas 2';
            } else {
                $status = 'Aman';
            }

            $data[] = [
                'cadanganbb_id' => $cadangan->cadanganbb_id,
                'opco_id' => $cadangan->opco_id,
                'tahun_habis' => $sisaTahun,
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('umurcadangan')->insert($data);
    }
}
