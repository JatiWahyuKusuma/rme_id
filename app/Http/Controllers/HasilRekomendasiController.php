<?php

namespace App\Http\Controllers;

use App\Models\CadanganbbModel;
use App\Models\KriteriaModel;
use App\Models\OpcoModel;
use App\Models\SubKriteriaModel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class HasilRekomendasiController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Hasil Rekomendasi Prioritas Perluasan Lahan Bahan Baku',
            'list' => ['Home', 'Rekomendasi']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'rekomendasi';
        $rekomcadanganbb = CadanganbbModel::where('umur_cadangan_thn', '<', 5)->get();
        $opco = OpcoModel::all();
        $kriteria = KriteriaModel::all();

        // Ambil data alternatif yang memenuhi syarat
        $detailAlternatif = CadanganbbModel::select(
            'cadanganbb_id',
            'lokasi_iup',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin',
            'status_pembebasan'
        )->where('umur_cadangan_thn', '<', 5)->get();

        // Perhitungan Bobot & Normalisasi seperti pada DetailHasilRekomendasiController
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

        // Normalisasi dan Perangkingan
        $minC1 = $detailAlternatif->min('umur_cadangan_bobot') ?: 1;
        $minC2 = $detailAlternatif->min('umur_masa_berlaku_izin_bobot') ?: 1;
        $minC3 = $detailAlternatif->min('status_pembebasan_bobot') ?: 1;

        $bobotC1 = KriteriaModel::where('nama_kriteria', 'Umur Cadangan')->value('bobot_kriteria');
        $bobotC2 = KriteriaModel::where('nama_kriteria', 'Umur Masa Berlaku Izin')->value('bobot_kriteria');
        $bobotC3 = KriteriaModel::where('nama_kriteria', 'Status Pembebasan')->value('bobot_kriteria');

        foreach ($detailAlternatif as $cadangan) {
            $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0) ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot) : 0;
            $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0) ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot) : 0;
            $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0) ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot) : 0;

            $cadangan->total_bobot =
                ($cadangan->normalisasi_c1 * $bobotC1) +
                ($cadangan->normalisasi_c2 * $bobotC2) +
                ($cadangan->normalisasi_c3 * $bobotC3);
        }

        $detailAlternatifRanked = $detailAlternatif->sortByDesc('total_bobot')->values();

        // Tambahkan ranking
        foreach ($detailAlternatifRanked as $index => $cadangan) {
            $cadangan->ranking = $index + 1;
        }
        return view('superadmin.rekomendasi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'opco' => $opco,
            'kriteria' => $kriteria,
            'detailAlternatif' => $detailAlternatifRanked
        ]);
    }
    public function cetakPdf()
    {
        $detailAlternatif = CadanganbbModel::select(
            'cadanganbb_id',
            'lokasi_iup',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin',
            'status_pembebasan'
        )->where('umur_cadangan_thn', '<', 5)->get();
        // Perhitungan Bobot & Normalisasi seperti pada DetailHasilRekomendasiController
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

        // Normalisasi dan Perangkingan
        $minC1 = $detailAlternatif->min('umur_cadangan_bobot') ?: 1;
        $minC2 = $detailAlternatif->min('umur_masa_berlaku_izin_bobot') ?: 1;
        $minC3 = $detailAlternatif->min('status_pembebasan_bobot') ?: 1;

        $bobotC1 = KriteriaModel::where('nama_kriteria', 'Umur Cadangan')->value('bobot_kriteria');
        $bobotC2 = KriteriaModel::where('nama_kriteria', 'Umur Masa Berlaku Izin')->value('bobot_kriteria');
        $bobotC3 = KriteriaModel::where('nama_kriteria', 'Status Pembebasan')->value('bobot_kriteria');

        foreach ($detailAlternatif as $cadangan) {
            $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0) ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot) : 0;
            $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0) ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot) : 0;
            $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0) ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot) : 0;

            $cadangan->total_bobot =
                ($cadangan->normalisasi_c1 * $bobotC1) +
                ($cadangan->normalisasi_c2 * $bobotC2) +
                ($cadangan->normalisasi_c3 * $bobotC3);
        }

        $detailAlternatifRanked = $detailAlternatif->sortByDesc('total_bobot')->values();

        // Tambahkan ranking
        foreach ($detailAlternatifRanked as $index => $cadangan) {
            $cadangan->ranking = $index + 1;
        }
        $pdf = Pdf::loadView('superadmin.rekomendasi.cetak', [
            'detailAlternatif' => $detailAlternatifRanked
        ]);

        return $pdf->download('rekomendasi_perluasan_lahan.pdf');
    }

    public function list(Request $request)
    {

        $rekomcadanganbb = CadanganbbModel::select(
            'cadanganbb_id',
            'opco_id',
            'latitude',
            'longitude',
            'jarak',
            'luas_ha',
            'kebutuhan_pertahun_ton',
            'komoditi',
            'lokasi_iup',
            'sd_cadangan_ton',
            'status_penyelidikan',
            'status_pembebasan',
            'catatan',
            'kabupaten',
            'kecamatan',
            'luas_ha',
            'masa_berlaku_iup',
            'masa_berlaku_ppkh',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin'
        )
            ->where('umur_cadangan_thn', '<', 5);

        if ($request->opco_id) {
            $rekomcadanganbb->where('opco_id', $request->opco_id);
        }
        return Datatables::of($rekomcadanganbb)
            ->addIndexColumn()
            ->make(true);
    }

    public function riwayat()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Penilaian Penerbitan Prioritas Perluasan Lahan ',
            'list' => ['Home', 'history']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'history';
        $history = CadanganbbModel::all();
        $opco = OpcoModel::all();

        return view('superadmin.history.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'history' => $history, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }
}
