<?php

namespace App\Http\Controllers;

use App\Models\CadanganbbModel;
use Illuminate\Http\Request;

class NotifikasiAdminController extends Controller
{
    public function getNotifikasi()
    {
        $opcoId = auth()->user()->admin->opco_id;

        // Ambil data cadangan dengan umur kurang dari 5 tahun
        $UmurCadanganNotifikasi = CadanganbbModel::where('opco_id', $opcoId)
            ->where('umur_cadangan_thn', '<', 5)
            ->get(['lokasi_iup', 'umur_cadangan_thn']);

        // Ambil data dengan umur masa berlaku izin kurang dari 1 tahun atau sudah lewat
        $UmurizinNotifikasi = CadanganbbModel::where('opco_id', $opcoId)
            ->where(function ($query) {
                $query->where('umur_masa_berlaku_izin', '<', 1)
                    ->orWhereNull('umur_masa_berlaku_izin'); // Jika izin kosong/null
            })
            ->get(['lokasi_iup', 'umur_masa_berlaku_izin']);

        return response()->json([
            'cadangan' => $UmurCadanganNotifikasi,
            'izin' => $UmurizinNotifikasi
        ]);
    }
}
