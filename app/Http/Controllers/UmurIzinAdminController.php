<?php

namespace App\Http\Controllers;

use App\Models\OpcoModel;
use App\Models\UmurCadanganModel;
use App\Models\UmurIzinModel;
use Illuminate\Http\Request;

class UmurIzinAdminController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'MENGECEK MASA BERLAKU IZIN CADANGAN BAHAN BAKU ',
            'list' => ['Home', 'Umur Cadangan']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'umurizinadmin';
        $opco = OpcoModel::all();
        $lokasi_iup_all = UmurCadanganModel::leftJoin('m_cadangan_bb', 'umurcadangan.cadanganbb_id', '=', 'm_cadangan_bb.cadanganbb_id')
            ->select('m_cadangan_bb.lokasi_iup');

        if ($request->has('opco_id') && $request->opco_id) {
            $lokasi_iup_all->where('umurcadangan.opco_id', $request->opco_id);
        }

        $lokasi_iup_all = $lokasi_iup_all->distinct()->pluck('m_cadangan_bb.lokasi_iup');

        $cadanganbb = UmurIzinModel::select(
            'umurizin_id',
            'm_opco.nama_opco',
            'm_cadangan_bb.lokasi_iup',
            'm_cadangan_bb.umur_masa_berlaku_izin',
            'umurizin.tahun_habis',
            'umurizin.status'
        )
            ->leftJoin('m_cadangan_bb', 'umurizin.cadanganbb_id', '=', 'm_cadangan_bb.cadanganbb_id')
            ->leftJoin('m_opco', 'umurizin.opco_id', '=', 'm_opco.opco_id');

        // Filter jika ada input opco_id
        if ($request->opco_id) {
            $cadanganbb->where('umurizin.opco_id', $request->opco_id);
        }

        if ($request->lokasi_iup) {
            $cadanganbb->where('m_cadangan_bb.lokasi_iup', $request->lokasi_iup);
        }
        $cadanganbb = $cadanganbb->get();
        if ($request->ajax() && $request->has('opco_id')) {
            return response()->json($lokasi_iup_all);
        }

        return view('admin.umurizin.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'opco' => $opco,
            'activeMenu' => $activeMenu,
            'cadanganbb' => $cadanganbb,
            'lokasi_iup_all' => $lokasi_iup_all
        ]);
    }
}
