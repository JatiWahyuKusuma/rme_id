<?php

namespace App\Http\Controllers;

use App\Models\OpcoModel;
use App\Models\UmurCadanganModel;
use Illuminate\Http\Request;

class UmurCadanganController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'MENGECEK UMUR CADANGAN BAHAN BAKU ',
            'list' => ['Home', 'Umur Cadangan']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'umurcadangan';
        $opco = OpcoModel::all();

        // Get lokasi_iup based on selected opco_id (if any)
        $lokasi_iup_all = UmurCadanganModel::leftJoin('m_cadangan_bb', 'umurcadangan.cadanganbb_id', '=', 'm_cadangan_bb.cadanganbb_id')
            ->select('m_cadangan_bb.lokasi_iup');

        if ($request->has('opco_id') && $request->opco_id) {
            $lokasi_iup_all->where('umurcadangan.opco_id', $request->opco_id);
        }

        $lokasi_iup_all = $lokasi_iup_all->distinct()->pluck('m_cadangan_bb.lokasi_iup');

        $cadanganbb = UmurCadanganModel::select(
            'umurcadangan_id',
            'm_opco.nama_opco',
            'm_cadangan_bb.lokasi_iup',
            'm_cadangan_bb.umur_cadangan_thn',
            'umurcadangan.tahun_habis',
            'umurcadangan.status'
        )
            ->leftJoin('m_cadangan_bb', 'umurcadangan.cadanganbb_id', '=', 'm_cadangan_bb.cadanganbb_id')
            ->leftJoin('m_opco', 'umurcadangan.opco_id', '=', 'm_opco.opco_id');

        // Filter jika ada input opco_id
        if ($request->opco_id) {
            $cadanganbb->where('umurcadangan.opco_id', $request->opco_id);
        }

        if ($request->lokasi_iup) {
            $cadanganbb->where('m_cadangan_bb.lokasi_iup', $request->lokasi_iup);
        }

        $cadanganbb = $cadanganbb->get();

        // If this is an AJAX request for lokasi_iup options, return just those
        if ($request->ajax() && $request->has('opco_id')) {
            return response()->json($lokasi_iup_all);
        }

        return view('superadmin.umurcadangan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'opco' => $opco,
            'activeMenu' => $activeMenu,
            'cadanganbb' => $cadanganbb,
            'lokasi_iup_all' => $lokasi_iup_all
        ]);
    }
}