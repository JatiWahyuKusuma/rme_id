<?php

namespace App\Http\Controllers;

use App\Models\CadangandanPotensiModel;
use App\Models\OpcoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminCadpotController extends Controller
{
    public function index(Request $request)
    {
        $userOpcoId = auth()->user()->admin->opco_id;

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Cadangan dan Potensi Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Cadangan dan Potensi Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang']
            ];
        }

        $page = (object)[
            'title' => 'Daftar Cadangan dan Potensi Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'admincadpot';
        $admincadpot = CadangandanPotensiModel::orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId])
            ->get();

        $opco = OpcoModel::all();;

        return view('admin.cadangan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadpot' => $admincadpot, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }
    public function list(Request $request)
    {
        // Ambil opco_id dari pengguna yang sedang login
        $userOpcoId = auth()->user()->admin->opco_id;

        // Ambil data cadangan dan potensi
        $admincadpot = CadangandanPotensiModel::select(
            'cadpot_id',
            'opco_id',
            'jarak',
            'latitude',
            'longitude',
            'no_id',
            'komoditi',
            'lokasi_iup',
            'tipe_sd_cadangan',
            'sd_cadangan_ton',
            'catatan',
            'status_penyelidikan',
            'acuan',
            'kabupaten',
            'kecamatan',
            'luas_ha',
            'masa_berlaku_iup',
            'masa_berlaku_ppkh'
        )->orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId]);

        // Filter berdasarkan opco_id jika tersedia
        if ($request->opco_id) {
            $admincadpot->where('opco_id', $request->opco_id);
        }


        // Konfigurasi untuk Datatables
        return Datatables::of($admincadpot)
            ->addIndexColumn()
            ->addColumn('aksi', function ($admincadpot) use ($userOpcoId) {
                // Hanya tampilkan tombol jika opco_id data sama dengan opco_id pengguna yang login
                if ($admincadpot->opco_id == $userOpcoId) {
                    $btn  = '<a href="' . url('/admincadpot/' . $admincadpot->cadpot_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/admincadpot/' . $admincadpot->cadpot_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admincadpot/' . $admincadpot->cadpot_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                    return $btn;
                }
                // Jika opco_id tidak sama, jangan tampilkan tombol apapun
                return '';
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

        $admincadpot = CadangandanPotensiModel::all();
        $activeMenu = 'admincadpot';
        $opcoId = auth()->user()->admin->opco_id;

        return view('admin.cadangan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadpot' => $admincadpot, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'jarak' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'no_id' => 'nullable|integer',
            'komoditi' => 'required|string',
            'lokasi_iup' => 'required|string',
            'tipe_sd_cadangan' => 'required|string',
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

        $loggedOpcoId = auth()->user()->admin->opco_id;

        // Ensure the form's opco_id matches the logged-in user's opco_id
        if ($request->opco_id != $loggedOpcoId) {
            return redirect()->back()->withErrors('You are not authorized to add data for this Opco.');
        }

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

        return redirect('/admincadpot')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $admincadpot = CadangandanPotensiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Data GHOPO Cadangan dan Potensi Bahan Baku di SIG',
            'list' => ['Home', 'Cadangan & Potensi', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'admincadpot';

        return view('admin.Cadangan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadpot' => $admincadpot, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $admincadpot = CadangandanPotensiModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Cadangan atau Potensi Bahan Baku',
            'list' => ['Home', 'GHOPO Tuban', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        if (!$admincadpot || $admincadpot->opco_id != auth()->user()->admin->opco_id) {
            return redirect('/admincadpot')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }

        $opcoId = auth()->user()->admin->opco_id;

        $activeMenu = 'admincadpot';


        return view('admin.Cadangan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadpot' => $admincadpot, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'jarak' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'no_id' => 'nullable|integer',
            'komoditi' => 'required|string',
            'lokasi_iup' => 'required|string',
            'tipe_sd_cadangan' => 'required|string',
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
        $loggedOpcoId = auth()->user()->admin->opco_id;
        $admincadpot = CadangandanPotensiModel::find($id);

        if (!$admincadpot || $admincadpot->opco_id != $loggedOpcoId) {
            return redirect('/admincadpot')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }


        // Ensure the form's opco_id matches the logged-in user's opco_id
        if ($request->opco_id != $loggedOpcoId) {
            return redirect()->back()->withErrors('You are not authorized to add data for this Opco.');
        }

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
        return redirect('/admincadpot')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $check = CadangandanPotensiModel::find($id);

        if (!$check) {
            return redirect('/admincadpot')->with('error', 'Data tidak ditemukan');
        }

        try {
            CadangandanPotensiModel::destroy($id);

            return redirect('/admincadpot')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admincadpot')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
