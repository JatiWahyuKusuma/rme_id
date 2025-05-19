<?php

namespace App\Http\Controllers;

use App\Models\CadanganbbModel;
use App\Models\KriteriaModel;
use App\Models\OpcoModel;
use App\Models\SubKriteriaModel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DetailHasilRekomendasiController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Perhitungan Hasil Rekomendasi ',
            'list' => ['Home', 'Rekomendasi', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'detailrekomendasi';
        $rekomcadanganbb = CadanganbbModel::where('umur_cadangan_thn', '<', 5)->get();
        $opco = OpcoModel::all();
        $kriteria = KriteriaModel::all();

        // Ambil data alternatif
        $detailAlternatif = CadanganbbModel::select(
            'cadanganbb_id',
            'lokasi_iup',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin',
            'status_pembebasan'
        )->where('umur_cadangan_thn', '<', 5)->get();

        $detailAlternatifAsli = $detailAlternatif->map(function ($item) {
            return clone $item;
        });

        //Tahap Detail Alternatif
        foreach ($detailAlternatif as $cadangan) {

            $cadangan->umur_cadangan_bobot = SubKriteriaModel::where('kriteria_id', 1)
                ->whereRaw('? <= CAST(REPLACE(nama_subkriteria, "<", "") AS SIGNED)', [$cadangan->umur_cadangan_thn])
                ->orderBy('bobot_subkriteria', 'desc')
                ->value('bobot_subkriteria');

            $cadangan->umur_masa_berlaku_izin_bobot = SubKriteriaModel::where('kriteria_id', 2)
                ->whereRaw('? >= CAST(REPLACE(nama_subkriteria, "> ", "") AS SIGNED)', [$cadangan->umur_masa_berlaku_izin])
                ->orderBy('bobot_subkriteria', 'asc')
                ->value('bobot_subkriteria');

            $cadangan->status_pembebasan_bobot = SubKriteriaModel::where('kriteria_id', 3)
                ->where('nama_subkriteria', $cadangan->status_pembebasan)
                ->value('bobot_subkriteria');
        }
        $minC1 = $detailAlternatif->min('umur_cadangan_bobot') ?: 0;
        $maxC1 = $detailAlternatif->max('umur_cadangan_bobot') ?: 0;

        $minC2 = $detailAlternatif->min('umur_masa_berlaku_izin_bobot') ?: 0;
        $maxC2 = $detailAlternatif->max('umur_masa_berlaku_izin_bobot') ?: 0;

        $minC3 = $detailAlternatif->min('status_pembebasan_bobot') ?: 0;
        $maxC3 = $detailAlternatif->max('status_pembebasan_bobot') ?: 0;

        //Tahap Normalisasi
        $minC1 = $detailAlternatif->min('umur_cadangan_bobot') ?: 1;
        $minC2 = $detailAlternatif->min('umur_masa_berlaku_izin_bobot') ?: 1;
        $minC3 = $detailAlternatif->min('status_pembebasan_bobot') ?: 1;

        //Pengambilan nilai bobot kriteria
        $bobotC1 = KriteriaModel::where('nama_kriteria', 'Umur Cadangan')->value('bobot_kriteria');
        $bobotC2 = KriteriaModel::where('nama_kriteria', 'Umur Masa Berlaku Izin')->value('bobot_kriteria');
        $bobotC3 = KriteriaModel::where('nama_kriteria', 'Status Pembebasan')->value('bobot_kriteria');

        foreach ($detailAlternatif as $cadangan) {
            $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0)
                ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot) : 0;

            $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0)
                ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot) : 0;

            $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0)
                ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot) : 0;

            //PERANGKINGAN
            // Perhitungan total bobot
            $cadangan->total_bobot =
                ($cadangan->normalisasi_c1 * $bobotC1) +
                ($cadangan->normalisasi_c2 * $bobotC2) +
                ($cadangan->normalisasi_c3 * $bobotC3);
        }
        // Ubah ini untuk sorting ascending (kriteria cost)
        $detailAlternatifRanked = $detailAlternatif->sortBy('total_bobot')->values();

        // Tambahkan ranking
        foreach ($detailAlternatifRanked as $index => $cadangan) {
            $cadangan->ranking = $index + 1;
        }

        return view('superadmin.detailrekomendasi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'cadanganbb' => $rekomcadanganbb,
            'activeMenu' => $activeMenu,
            'opco' => $opco,
            'kriteria' => $kriteria,
            'detailAlternatif' => $detailAlternatif,
            'minC1' => $minC1,
            'maxC1' => $maxC1,
            'minC2' => $minC2,
            'maxC2' => $maxC2,
            'minC3' => $minC3,
            'maxC3' => $maxC3
        ]);
    }

    public function list(Request $request)
    {

        $rekomcadanganbb = CadanganbbModel::select(
            'cadanganbb_id',
            'lokasi_iup',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin',
            'status_pembebasan'
        )->where('umur_cadangan_thn', '<', 5);

        if ($request->opco_id) {
            $rekomcadanganbb->where('opco_id', $request->opco_id);
        }

        // Konversi ke bobot_subkriteria
        return Datatables::of($rekomcadanganbb)
            ->addIndexColumn()
            ->make(true);
    }
}
