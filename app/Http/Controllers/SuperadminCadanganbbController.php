<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OpcoModel;
use Yajra\DataTables\DataTables;
use App\Models\CadanganbbModel;
use Barryvdh\DomPDF\Facade\Pdf;

class SuperadminCadanganbbController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Data Cadangan Bahan Baku di SIG',
            'list' => ['Home', 'Cadangan']
        ];

        $page = (object)[
            'title' => 'Daftar Cadangan Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'cadanganbb';
        $cadanganbb = CadanganbbModel::all();
        $opco = OpcoModel::all();

        return view('superadmin.cadanganbb.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadanganbb' => $cadanganbb, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function list(Request $request)
    {
        $cadanganbb = CadanganbbModel::select(
            'm_cadangan_bb.cadanganbb_id',
            'm_cadangan_bb.opco_id',
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
            'masa_berlaku_iup',
            'masa_berlaku_ppkh',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin',
            'm_opco.nama_opco' // pastikan ini ditambahkan di sini
        )->leftJoin('m_opco', 'm_cadangan_bb.opco_id', '=', 'm_opco.opco_id');

        if ($request->opco_id) {
            $cadanganbb->where('m_cadangan_bb.opco_id', $request->opco_id);
        }

        return DataTables::of($cadanganbb)
            ->addIndexColumn()
            ->filterColumn('nama_opco', function ($query, $keyword) {
                $query->where('m_opco.nama_opco', 'LIKE', "%{$keyword}%");
            })
            ->addColumn('aksi', function ($cadanganbb) {
                $btn  = '<a href="' . url('/cadanganbb/' . $cadanganbb->cadanganbb_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/cadanganbb/' . $cadanganbb->cadanganbb_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/cadanganbb/' . $cadanganbb->cadanganbb_id) . '">'
                    . csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Data Cadangan  Bahan Baku di SIG ',
            'list' => ['Home', 'Cadangan', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah data Cadangan Bahan Baku baru'
        ];

        $cadanganbb = CadanganbbModel::all();
        $activeMenu = 'cadanganbb';
        $opco = OpcoModel::all();

        return view('superadmin.Cadanganbb.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadanganbb' => $cadanganbb, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jarak' => 'nullable|numeric',
            'luas_ha' => 'nullable|numeric',
            'kebutuhan_pertahun_ton' => 'required|integer',
            'komoditi' => 'required|string',
            'lokasi_iup' => 'required|string',
            'sd_cadangan_ton' => 'required|integer',
            'status_penyelidikan' => 'nullable|string',
            'status_pembebasan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'masa_berlaku_iup' => 'nullable',
            'masa_berlaku_ppkh' => 'nullable',
            'umur_cadangan_thn' => 'nullable',
            'umur_masa_berlaku_izin' => 'nullable',
        ]);
        CadanganbbModel::create([
            'opco_id' => $request->opco_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jarak' => $request->jarak,
            'luas_ha' => $request->luas_ha,
            'kebutuhan_pertahun_ton' => $request->kebutuhan_pertahun_ton,
            'komoditi' => $request->komoditi,
            'lokasi_iup' => $request->lokasi_iup,
            'sd_cadangan_ton' => $request->sd_cadangan_ton,
            'status_penyelidikan' => $request->status_penyelidikan,
            'status_pembebasan' => $request->status_pembebasan,
            'catatan' => $request->catatan,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'masa_berlaku_iup' => $request->masa_berlaku_iup,
            'masa_berlaku_ppkh' => $request->masa_berlaku_ppkh,
            'umur_cadangan_thn' => ($request->sd_cadangan_ton / $request->kebutuhan_pertahun_ton),
            'umur_masa_berlaku_izin' => $request->umur_masa_berlaku_izin

        ]);

        return redirect('/cadanganbb')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $cadanganbb = CadanganbbModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Data Cadangan  Bahan Baku di SIG',
            'list' => ['Home', 'Cadangan ', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'cadanganbb';

        return view('superadmin.Cadanganbb.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadanganbb' => $cadanganbb, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $cadanganbb = CadanganbbModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Cadangan Bahan Baku',
            'list' => ['Home', 'Cadangan ', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'cadanganbb';

        return view('superadmin.Cadanganbb.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadanganbb' => $cadanganbb, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'jarak' => 'nullable|numeric',
            'luas_ha' => 'nullable|numeric',
            'kebutuhan_pertahun_ton' => 'required|integer',
            'komoditi' => 'required|string',
            'lokasi_iup' => 'required|string',
            'sd_cadangan_ton' => 'required|integer',
            'status_penyelidikan' => 'nullable|string',
            'status_pembebasan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'masa_berlaku_iup' => 'nullable',
            'masa_berlaku_ppkh' => 'nullable',
            'umur_cadangan_thn' => 'nullable',
            'umur_masa_berlaku_izin' => 'nullable',
        ]);

        CadanganbbModel::find($id)->update([
            'opco_id' => $request->opco_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'jarak' => $request->jarak,
            'luas_ha' => $request->luas_ha,
            'kebutuhan_pertahun_ton' => $request->kebutuhan_pertahun_ton,
            'komoditi' => $request->komoditi,
            'lokasi_iup' => $request->lokasi_iup,
            'sd_cadangan_ton' => $request->sd_cadangan_ton,
            'status_penyelidikan' => $request->status_penyelidikan,
            'status_pembebasan' => $request->status_pembebasan,
            'catatan' => $request->catatan,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'masa_berlaku_iup' => $request->masa_berlaku_iup,
            'masa_berlaku_ppkh' => $request->masa_berlaku_ppkh,
            'umur_cadangan_thn' => ($request->sd_cadangan_ton / $request->kebutuhan_pertahun_ton),
            'umur_masa_berlaku_izin' => $request->umur_masa_berlaku_izin
        ]);
        return redirect('/cadanganbb')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $check = CadanganbbModel::find($id);

        if (!$check) {
            return redirect('/cadanganbb')->with('error', 'Data tidak ditemukan');
        }

        try {
            CadanganbbModel::destroy($id);

            return redirect('/cadanganbb')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/cadanganbb')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    // Add this method to SuperadminCadanganbbController
    public function exportPDF(Request $request)
    {
        try {
            $cadanganbb = CadanganbbModel::select(
                'm_cadangan_bb.cadanganbb_id',
                'm_cadangan_bb.opco_id',
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
                'masa_berlaku_iup',
                'masa_berlaku_ppkh',
                'umur_cadangan_thn',
                'umur_masa_berlaku_izin'
            )->leftJoin('m_opco', 'm_cadangan_bb.opco_id', '=', 'm_opco.opco_id')
                ->addSelect('m_opco.nama_opco');

            if ($request->has('opco_id') && $request->opco_id) {
                $cadanganbb->where('m_cadangan_bb.opco_id', $request->opco_id);
            }

            $data = $cadanganbb->get();

            if ($data->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data yang ditemukan untuk diekspor');
            }

            $filterOpco = $request->opco_id ? OpcoModel::find($request->opco_id)->nama_opco : 'Semua';

            $pdf = PDF::loadView('superadmin.cadanganbb.pdf', [
                'data' => $data,
                'filterOpco' => $filterOpco,
                'tahun' => $request->tahun,
                'periode' => $request->periode
            ])->setPaper('a4', 'landscape');

            return $pdf->download('cadangan_bahan_baku_' . $request->tahun . '_' . $request->periode . '_' . date('YmdHis') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengekspor PDF: ' . $e->getMessage());
        }
    }
}
