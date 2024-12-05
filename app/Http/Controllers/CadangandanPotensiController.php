<?php

namespace App\Http\Controllers;

use App\Models\CadangandanPotensiModel;
use App\Models\OpcoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CadangandanPotensiController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Cadangan dan Potensi Bahan Baku di SIG',
            'list' => ['Home', 'Cadangan']
        ];

        $page = (object)[
            'title' => 'Daftar Cadangan dan Potensi Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'cadpot';
        $cadpot = CadangandanPotensiModel::all();
        $opco = OpcoModel::all();

        return view('superadmin.cadangan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadpot' => $cadpot, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function list(Request $request)
    {

        $cadpot = CadangandanPotensiModel::select('cadpot_id', 'opco_id', 'jarak', 'latitude', 'longitude', 'no_id', 'komoditi', 'lokasi_iup', 'tipe_sd_cadangan', 'sd_cadangan_ton', 'catatan', 'status_penyelidikan', 'acuan', 'kabupaten', 'kecamatan', 'luas_ha', 'masa_berlaku_iup', 'masa_berlaku_ppkh');

        if ($request->opco_id) {
            $cadpot->where('opco_id', $request->opco_id); 
        }
        return Datatables::of($cadpot)
            ->addIndexColumn()
            ->addColumn('aksi', function ($cadpot) {
                $btn  = '<a href="' . url('/cadpot/' . $cadpot->cadpot_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/cadpot/' . $cadpot->cadpot_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/cadpot/' . $cadpot->cadpot_id) . '">'
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
            'title' => 'Tambah Data Cadangan dan Potensi Bahan Baku di SIG ',
            'list' => ['Home', 'Cadangan', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah data Cadangan / Potensi Bahan Baku baru'
        ];

        $cadpot = CadangandanPotensiModel::all();
        $activeMenu = 'cadpot';
        $opco = OpcoModel::all();

        return view('superadmin.Cadangan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadpot' => $cadpot, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'jarak' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'no_id' => 'nullable|integer',
            'komoditi' => 'required|string',
            'lokasi_iup' => 'required|string',
            'tipe_sd_cadangan' => 'nullable|string',
            'sd_cadangan_ton' => 'required|integer',
            'catatan' => 'nullable|string',
            'status_penyelidikan' => 'nullable|string',
            'acuan' => 'nullable|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'luas_ha' => 'nullable|numeric',
            'masa_berlaku_iup' => 'nullable',
            'masa_berlaku_ppkh' => 'nullable',

        ]);
        CadangandanPotensiModel::create([
            'opco_id' => $request->opco_id,
            'jarak' => $request->jarak,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'no_id' => $request->no_id,
            'komoditi' => $request->komoditi,
            'lokasi_iup' => $request->lokasi_iup,
            'tipe_sd_cadangan' => $request->tipe_sd_cadangan,
            'sd_cadangan_ton' => $request->sd_cadangan_ton,
            'catatan' => $request->catatan,
            'status_penyelidikan' => $request->status_penyelidikan,
            'acuan' => $request->acuan,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'luas_ha' => $request->luas_ha,
            'masa_berlaku_iup' => $request->masa_berlaku_iup,
            'masa_berlaku_ppkh' => $request->masa_berlaku_ppkh

        ]);

        return redirect('/cadpot')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $cadpot = CadangandanPotensiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Data Cadangan dan Potensi Bahan Baku di SIG',
            'list' => ['Home', 'Cadangan dan Potensi', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'cadpot';

        return view('superadmin.Cadangan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadpot' => $cadpot, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $cadpot = CadangandanPotensiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Cadangan atau Potensi Bahan Baku',
            'list' => ['Home', 'Cadangan dan Potensi', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'cadpot';

        return view('superadmin.Cadangan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'cadpot' => $cadpot, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'jarak' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'no_id' => 'nullable|integer',
            'komoditi' => 'required|string',
            'lokasi_iup' => 'required|string',
            'tipe_sd_cadangan' => 'nullable|string',
            'sd_cadangan_ton' => 'required|integer',
            'catatan' => 'nullable|string',
            'status_penyelidikan' => 'nullable|string',
            'acuan' => 'nullable|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'luas_ha' => 'nullable|numeric',
            'masa_berlaku_iup' => 'nullable',
            'masa_berlaku_ppkh' => 'nullable',
        ]);

        CadangandanPotensiModel::find($id)->update([
            'opco_id' => $request->opco_id,
            'jarak' => $request->jarak,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'no_id' => $request->no_id,
            'komoditi' => $request->komoditi,
            'lokasi_iup' => $request->lokasi_iup,
            'tipe_sd_cadangan' => $request->tipe_sd_cadangan,
            'sd_cadangan_ton' => $request->sd_cadangan_ton,
            'catatan' => $request->catatan,
            'status_penyelidikan' => $request->status_penyelidikan,
            'acuan' => $request->acuan,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'luas_ha' => $request->luas_ha,
            'masa_berlaku_iup' => $request->masa_berlaku_iup,
            'masa_berlaku_ppkh' => $request->masa_berlaku_ppkh
        ]);
        return redirect('/cadpot')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $check = CadangandanPotensiModel::find($id);

        if (!$check) {
            return redirect('/cadpot')->with('error', 'Data tidak ditemukan');
        }

        try {
            CadangandanPotensiModel::destroy($id);

            return redirect('/cadpot')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/cadpot')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
