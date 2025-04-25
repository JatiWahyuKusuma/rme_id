<?php

namespace App\Http\Controllers;

use App\Models\CadanganbbModel;
use Illuminate\Http\Request;

class NotifikasiSuperadminController extends Controller
{
    public function getNotifications()
    {
        // Ambil data cadangan dengan umur kurang dari 5 tahun
        $UmurCadanganNotifikasi = CadanganbbModel::select('opco_id', 'lokasi_iup', 'umur_cadangan_thn')
            ->where('umur_cadangan_thn', '<', 5)
            ->get();

        // Ambil data dengan umur masa berlaku izin kurang dari 1 tahun atau sudah lewat
        $UmurizinNotifikasi = CadanganbbModel::select('opco_id', 'lokasi_iup', 'umur_masa_berlaku_izin')
            ->where('umur_masa_berlaku_izin', '<', 1)
            ->orWhereNull('umur_masa_berlaku_izin') // Jika ada data izin yang kosong/null
            ->get();

        return response()->json([
            'cadangan' => $UmurCadanganNotifikasi,
            'izin' => $UmurizinNotifikasi
        ]);
    }
}
