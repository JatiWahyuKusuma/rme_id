<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UmurIzinSeeder extends Seeder
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
            $izinString = strtolower(trim($cadangan->umur_masa_berlaku_izin));
            if (strpos($izinString, 'terlewat') !== false) {
                $umurizin = 0;
            } else {
                // Ambil angka tahun dari string (misal: "4 tahun 2 bulan")
                preg_match('/(\d+)\s*tahun/', $izinString, $matches);
                $umurizin = isset($matches[1]) ? (int) $matches[1] : 0;
            }
    
            // Hitung tahun habis
            $sisaTahun = ($umurizin > 0) ? $currentYear + $umurizin : $currentYear;


            if ($umurizin < 1) {
                $status = 'Critical';
            } elseif ($umurizin >= 1 && $umurizin <= 2) {
                $status = 'Prioritas 1';
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
        DB::table('umurizin')->insert($data);
    }
}
