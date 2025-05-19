<?php

namespace App\Http\Controllers;

use App\Models\CadanganbbModel;
use App\Models\KriteriaModel;
use App\Models\OpcoModel;
use App\Models\SubKriteriaModel;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

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

        // Filter out items that have been saved
        $savedItems = Cache::get('saved_items', []);
        $detailAlternatif = $detailAlternatif->reject(function ($item) use ($savedItems) {
            return in_array($item->cadanganbb_id, $savedItems);
        });

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

        $detailAlternatifRanked = $detailAlternatif->sortBy('total_bobot')->values();
        // Tambahkan ranking (1 sampai N meskipun ada nilai yang sama)
        foreach ($detailAlternatif as $cadangan) {
            $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0)
                ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot) : 0;

            $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0)
                ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot) : 0;

            $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0)
                ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot) : 0;

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
        // Ambil data alternatif
        $detailAlternatif = CadanganbbModel::select(
            'cadanganbb_id',
            'lokasi_iup',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin',
            'status_pembebasan'
        )->where('umur_cadangan_thn', '<', 5)->get();

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

        $detailAlternatifRanked = $detailAlternatif->sortBy('total_bobot')->values();

        // Tambahkan ranking
        foreach ($detailAlternatifRanked as $idx => $cadangan) {
            $cadangan->ranking = $idx + 1;
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
            'title' => '',
            'list' => ['Home', 'history']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'history';
        $history = Cache::get('penilaian_history', []);
        $opco = OpcoModel::all();

        return view('superadmin.history.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'history' => $history,
            'activeMenu' => $activeMenu,
            'opco' => $opco
        ]);
    }
    // Add this method to HasilRekomendasiController
    public function simpanPenilaian(Request $request)
    {
        try {
            // Ambil data alternatif yang memenuhi syarat
            $detailAlternatif = CadanganbbModel::select(
                'cadanganbb_id',
                'lokasi_iup',
                'umur_cadangan_thn',
                'umur_masa_berlaku_izin',
                'status_pembebasan',
                'opco_id'
            )->where('umur_cadangan_thn', '<', 5)->get();

            // Filter out items that have been saved
            $savedItems = Cache::get('saved_items', []);
            $filteredAlternatif = $detailAlternatif->reject(function ($item) use ($savedItems) {
                return in_array($item->cadanganbb_id, $savedItems);
            });

            // Proses perhitungan SPK hanya untuk yang belum disimpan
            foreach ($filteredAlternatif as $cadangan) {
                $cadangan->umur_cadangan_bobot = SubKriteriaModel::where('kriteria_id', 1)
                    ->whereRaw('? <= CAST(REPLACE(nama_subkriteria, "<", "") AS SIGNED)', [$cadangan->umur_cadangan_thn])
                    ->orderBy('bobot_subkriteria', 'desc')
                    ->value('bobot_subkriteria') ?? 1;

                $cadangan->umur_masa_berlaku_izin_bobot = SubKriteriaModel::where('kriteria_id', 2)
                    ->whereRaw('? >= CAST(REPLACE(nama_subkriteria, "> ", "") AS SIGNED)', [$cadangan->umur_masa_berlaku_izin])
                    ->orderBy('bobot_subkriteria', 'asc')
                    ->value('bobot_subkriteria') ?? 1;

                $cadangan->status_pembebasan_bobot = SubKriteriaModel::where('kriteria_id', 3)
                    ->where('nama_subkriteria', $cadangan->status_pembebasan)
                    ->value('bobot_subkriteria') ?? 1;
            }

            // Normalisasi dan perhitungan total bobot
            $minC1 = $filteredAlternatif->min('umur_cadangan_bobot') ?? 1;
            $minC2 = $filteredAlternatif->min('umur_masa_berlaku_izin_bobot') ?? 1;
            $minC3 = $filteredAlternatif->min('status_pembebasan_bobot') ?? 1;

            $bobotC1 = KriteriaModel::where('nama_kriteria', 'Umur Cadangan')->value('bobot_kriteria') ?? 0;
            $bobotC2 = KriteriaModel::where('nama_kriteria', 'Umur Masa Berlaku Izin')->value('bobot_kriteria') ?? 0;
            $bobotC3 = KriteriaModel::where('nama_kriteria', 'Status Pembebasan')->value('bobot_kriteria') ?? 0;

            foreach ($filteredAlternatif as $cadangan) {
                $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0)
                    ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot) : 0;
                $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0)
                    ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot) : 0;
                $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0)
                    ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot) : 0;

                $cadangan->total_bobot =
                    ($cadangan->normalisasi_c1 * $bobotC1) +
                    ($cadangan->normalisasi_c2 * $bobotC2) +
                    ($cadangan->normalisasi_c3 * $bobotC3);
            }

            // Ranking hanya untuk yang belum disimpan
            $detailAlternatifRanked = $filteredAlternatif->sortBy('total_bobot')->values();

            // Dapatkan ranking 1 dari yang belum disimpan
            $topResult = $detailAlternatifRanked->first();

            if (!$topResult) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang bisa disimpan'
                ], 400);
            }

            // Simpan ke cache history
            $history = Cache::get('penilaian_history', []);
            $history[] = [
                'lokasi_iup' => $topResult->lokasi_iup,
                'total_skor' => number_format($topResult->total_bobot, 2, ',', '.'),
                'tanggal_simpan' => now()->format('Y-m-d H:i:s'),
                'opco_id' => $topResult->opco_id,
                'data' => $topResult // Simpan seluruh data untuk restore
            ];
            Cache::put('penilaian_history', $history);

            // Tambahkan ke daftar yang sudah disimpan
            $savedItems[] = $topResult->cadanganbb_id;
            Cache::put('saved_items', array_unique($savedItems));

            return response()->json([
                'success' => true,
                'message' => 'Penilaian berhasil disimpan!',
                'redirect' => route('superadmin.history.index')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan penilaian: ' . $e->getMessage()
            ], 500);
        }
    }

    public function restorePenilaian($index)
    {
        try {
            $history = Cache::get('penilaian_history', []);

            if (!isset($history[$index])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data history tidak ditemukan'
                ], 404);
            }

            $itemToRestore = $history[$index];

            // Hapus dari daftar saved_items
            $savedItems = Cache::get('saved_items', []);
            $savedItems = array_diff($savedItems, [$itemToRestore['data']->cadanganbb_id]);
            Cache::put('saved_items', $savedItems);

            // Hapus dari history
            unset($history[$index]);
            Cache::put('penilaian_history', array_values($history));

            // Gunakan route yang benar sesuai definisi route
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil direstore',
                'redirect' => route('superadmin.history.index') // Diubah dari superadmin.rekomendasi.index ke rekomendasi.index
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal merestore data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function showDetail($index)
    {
        $history = Cache::get('penilaian_history', []);

        // Convert index to integer and validate
        $index = (int)$index;
        if ($index < 0 || !isset($history[$index])) {
            return redirect()->route('superadmin.history.index')->with('error', 'Data history tidak ditemukan');
        }

        $breadcrumb = (object) [
            'title' => 'Detail Perhitungan Hasil Rekomendasi',
            'list' => ['Home', 'History', 'Detail']
        ];

        $page = (object)['title' => ''];
        $activeMenu = 'history';

        // Get all alternatives where umur_cadangan_thn < 5
        $detailAlternatif = CadanganbbModel::where('umur_cadangan_thn', '<', 5)->get();

        // Filter out items that have been saved EXCEPT the current one being viewed
        $savedItems = Cache::get('saved_items', []);
        $currentItemId = $history[$index]['data']->cadanganbb_id;

        $detailAlternatif = $detailAlternatif->filter(function ($item) use ($savedItems, $currentItemId) {
            // Include current item and items not saved
            return $item->cadanganbb_id == $currentItemId || !in_array($item->cadanganbb_id, $savedItems);
        });

        // Process SPK calculation
        foreach ($detailAlternatif as $cadangan) {
            $cadangan->umur_cadangan_bobot = SubKriteriaModel::where('kriteria_id', 1)
                ->whereRaw('? <= CAST(REPLACE(nama_subkriteria, "<", "") AS SIGNED)', [$cadangan->umur_cadangan_thn])
                ->orderBy('bobot_subkriteria', 'desc')
                ->value('bobot_subkriteria') ?? 1; // Default to 1 if null

            $cadangan->umur_masa_berlaku_izin_bobot = SubKriteriaModel::where('kriteria_id', 2)
                ->whereRaw('? >= CAST(REPLACE(nama_subkriteria, "> ", "") AS SIGNED)', [$cadangan->umur_masa_berlaku_izin])
                ->orderBy('bobot_subkriteria', 'asc')
                ->value('bobot_subkriteria') ?? 1; // Default to 1 if null

            $cadangan->status_pembebasan_bobot = SubKriteriaModel::where('kriteria_id', 3)
                ->where('nama_subkriteria', $cadangan->status_pembebasan)
                ->value('bobot_subkriteria') ?? 1; // Default to 1 if null
        }

        // Calculate min and max values with proper defaults
        $minC1 = $detailAlternatif->min('umur_cadangan_bobot') ?? 1;
        $minC2 = $detailAlternatif->min('umur_masa_berlaku_izin_bobot') ?? 1;
        $minC3 = $detailAlternatif->min('status_pembebasan_bobot') ?? 1;
        $maxC1 = $detailAlternatif->max('umur_cadangan_bobot') ?? 1;
        $maxC2 = $detailAlternatif->max('umur_masa_berlaku_izin_bobot') ?? 1;
        $maxC3 = $detailAlternatif->max('status_pembebasan_bobot') ?? 1;

        // Get criteria weights
        $bobotC1 = KriteriaModel::where('nama_kriteria', 'Umur Cadangan')->value('bobot_kriteria') ?? 0;
        $bobotC2 = KriteriaModel::where('nama_kriteria', 'Umur Masa Berlaku Izin')->value('bobot_kriteria') ?? 0;
        $bobotC3 = KriteriaModel::where('nama_kriteria', 'Status Pembebasan')->value('bobot_kriteria') ?? 0;

        // Normalization and total weight calculation
        foreach ($detailAlternatif as $cadangan) {
            $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0)
                ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot)
                : 0;

            $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0)
                ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot)
                : 0;

            $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0)
                ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot)
                : 0;

            $cadangan->total_bobot =
                ($cadangan->normalisasi_c1 * $bobotC1) +
                ($cadangan->normalisasi_c2 * $bobotC2) +
                ($cadangan->normalisasi_c3 * $bobotC3);
        }

        // Ranking
        $detailAlternatifRanked = $detailAlternatif->sortBy('total_bobot')->values();
        foreach ($detailAlternatifRanked as $idx => $cadangan) {
            $cadangan->ranking = $idx + 1;
        }

        $kriteria = KriteriaModel::all();

        return view('superadmin.history.detail', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'detailAlternatif' => $detailAlternatifRanked,
            'kriteria' => $kriteria,
            'minC1' => $minC1,
            'minC2' => $minC2,
            'minC3' => $minC3,
            'maxC1' => $maxC1,
            'maxC2' => $maxC2,
            'maxC3' => $maxC3,
            'historyItem' => $history[$index]
        ]);
    }

    public function hapusRiwayat($index)
    {
        $history = Cache::get('penilaian_history', []);

        if (isset($history[$index])) {
            unset($history[$index]);
            $history = array_values($history); // Reindex array
            Cache::put('penilaian_history', $history);

            return response()->json([
                'success' => true,
                'message' => 'Riwayat berhasil dihapus'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Riwayat tidak ditemukan'
        ], 404);
    }
    public function cetakPdfRiwayat($index)
    {
        $history = Cache::get('penilaian_history', []);

        // Validasi index
        if (!isset($history[$index])) {
            abort(404, 'Data history tidak ditemukan');
        }

        // Ambil semua alternatif untuk perhitungan ranking
        $detailAlternatif = CadanganbbModel::where('umur_cadangan_thn', '<', 5)->get();
        $savedItems = Cache::get('saved_items', []);
        $currentItemId = $history[$index]['data']->cadanganbb_id;

        $detailAlternatif = $detailAlternatif->filter(function ($item) use ($savedItems, $currentItemId) {
            // Include current item and items not saved
            return $item->cadanganbb_id == $currentItemId || !in_array($item->cadanganbb_id, $savedItems);
        });
        // Proses perhitungan SPK seperti pada showDetail
        foreach ($detailAlternatif as $cadangan) {
            $cadangan->umur_cadangan_bobot = SubKriteriaModel::where('kriteria_id', 1)
                ->whereRaw('? <= CAST(REPLACE(nama_subkriteria, "<", "") AS SIGNED)', [$cadangan->umur_cadangan_thn])
                ->orderBy('bobot_subkriteria', 'desc')
                ->value('bobot_subkriteria') ?? 1;

            $cadangan->umur_masa_berlaku_izin_bobot = SubKriteriaModel::where('kriteria_id', 2)
                ->whereRaw('? >= CAST(REPLACE(nama_subkriteria, "> ", "") AS SIGNED)', [$cadangan->umur_masa_berlaku_izin])
                ->orderBy('bobot_subkriteria', 'asc')
                ->value('bobot_subkriteria') ?? 1;

            $cadangan->status_pembebasan_bobot = SubKriteriaModel::where('kriteria_id', 3)
                ->where('nama_subkriteria', $cadangan->status_pembebasan)
                ->value('bobot_subkriteria') ?? 1;
        }

        // Normalisasi dan perhitungan total bobot
        $minC1 = $detailAlternatif->min('umur_cadangan_bobot') ?? 1;
        $minC2 = $detailAlternatif->min('umur_masa_berlaku_izin_bobot') ?? 1;
        $minC3 = $detailAlternatif->min('status_pembebasan_bobot') ?? 1;

        $bobotC1 = KriteriaModel::where('nama_kriteria', 'Umur Cadangan')->value('bobot_kriteria') ?? 0;
        $bobotC2 = KriteriaModel::where('nama_kriteria', 'Umur Masa Berlaku Izin')->value('bobot_kriteria') ?? 0;
        $bobotC3 = KriteriaModel::where('nama_kriteria', 'Status Pembebasan')->value('bobot_kriteria') ?? 0;

        foreach ($detailAlternatif as $cadangan) {
            $cadangan->normalisasi_c1 = ($cadangan->umur_cadangan_bobot > 0)
                ? floatval($minC1) / floatval($cadangan->umur_cadangan_bobot) : 0;
            $cadangan->normalisasi_c2 = ($cadangan->umur_masa_berlaku_izin_bobot > 0)
                ? floatval($minC2) / floatval($cadangan->umur_masa_berlaku_izin_bobot) : 0;
            $cadangan->normalisasi_c3 = ($cadangan->status_pembebasan_bobot > 0)
                ? floatval($minC3) / floatval($cadangan->status_pembebasan_bobot) : 0;

            $cadangan->total_bobot =
                ($cadangan->normalisasi_c1 * $bobotC1) +
                ($cadangan->normalisasi_c2 * $bobotC2) +
                ($cadangan->normalisasi_c3 * $bobotC3);
        }

        // Ranking
        $detailAlternatifRanked = $detailAlternatif->sortBy('total_bobot')->values();
        foreach ($detailAlternatifRanked as $idx => $cadangan) {
            $cadangan->ranking = $idx + 1;
        }

        $pdf = Pdf::loadView('superadmin.history.cetakpdf', [
            'detailAlternatif' => $detailAlternatifRanked,
            'historyItem' => $history[$index],
            'tanggalCetak' => now()->format('Y-m-d H:i:s')
        ]);

        return $pdf->download('rekomendasi_perluasan_lahan_' . $history[$index]['lokasi_iup'] . '.pdf');
    }
}
