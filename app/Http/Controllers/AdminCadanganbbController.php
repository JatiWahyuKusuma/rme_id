<?php

namespace App\Http\Controllers;

use App\Models\CadanganbbModel;
use App\Models\OpcoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminCadanganbbController extends Controller
{
    public function index()
    {
        $userOpcoId = auth()->user()->admin->opco_id;

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang']
            ];
        } elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban']
            ];
        } elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa']
            ];
        } elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong']
            ];
        } elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap']
            ];
        } elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang']
            ];
        } elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Cadangan  Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja']
            ];
        }


        $page = (object)[
            'title' => 'Daftar Cadangan  Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'admincadanganbb';
        $admincadanganbb = CadanganbbModel::orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId])
            ->get();

        $opco = OpcoModel::all();

        return view('admin.cadanganbb.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadnaganbb' => $admincadanganbb, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function list(Request $request)
    {
        $userOpcoId = auth()->user()->admin->opco_id;

        // Ambil data cadangan 
        $admincadanganbb = CadanganbbModel::select(
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
            'masa_berlaku_iup',
            'masa_berlaku_ppkh',
            'umur_cadangan_thn',
            'umur_masa_berlaku_izin'
        )->orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId]);

        // Filter berdasarkan opco_id jika tersedia
        if ($request->opco_id) {
            $admincadanganbb->where('opco_id', $request->opco_id);
        }
        // Konfigurasi untuk Datatables
        return Datatables::of($admincadanganbb)
            ->addIndexColumn()
            ->addColumn('aksi', function ($admincadanganbb) use ($userOpcoId) {
                // Hanya tampilkan tombol jika opco_id data sama dengan opco_id pengguna yang login
                if ($admincadanganbb->opco_id == $userOpcoId) {
                    $btn  = '<a href="' . url('/admincadanganbb/' . $admincadanganbb->cadanganbb_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/admincadanganbb/' . $admincadanganbb->cadanganbb_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admincadanganbb/' . $admincadanganbb->cadanganbb_id) . '">'
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
        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Cadangan Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja', 'Tambah']
            ];
        }


        $page = (object)[
            'title' => 'Tambah data Cadangan Bahan Baku baru'
        ];

        $admincadanganbb = CadanganbbModel::all();
        $activeMenu = 'admincadanganbb';
        $opcoId = auth()->user()->admin->opco_id;

        return view('admin.cadanganbb.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadanganbb' => $admincadanganbb, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
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

        $loggedOpcoId = auth()->user()->admin->opco_id;

        // Ensure the form's opco_id matches the logged-in user's opco_id
        if ($request->opco_id != $loggedOpcoId) {
            return redirect()->back()->withErrors('You are not authorized to add data for this Opco.');
        }

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

        return redirect('/admincadanganbb')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $admincadanganbb = CadanganbbModel::find($id);

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Cadangan Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja', 'Detail']
            ];
        }

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'admincadanganbb';

        return view('admin.Cadanganbb.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadanganbb' => $admincadanganbb, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $admincadanganbb = CadanganbbModel::find($id);

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Cadangan Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja', 'Edit']
            ];
        }

        $page = (object)[
            'title' => ''
        ];

        if (!$admincadanganbb || $admincadanganbb->opco_id != auth()->user()->admin->opco_id) {
            return redirect('/admincadanganbb')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }

        $opcoId = auth()->user()->admin->opco_id;

        $activeMenu = 'admincadanganbb';


        return view('admin.Cadanganbb.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admincadanganbb' => $admincadanganbb, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
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
        $loggedOpcoId = auth()->user()->admin->opco_id;
        $admincadanganbb = CadanganbbModel::find($id);

        if (!$admincadanganbb || $admincadanganbb->opco_id != $loggedOpcoId) {
            return redirect('/admincadanganbb')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }


        // Ensure the form's opco_id matches the logged-in user's opco_id
        if ($request->opco_id != $loggedOpcoId) {
            return redirect()->back()->withErrors('You are not authorized to add data for this Opco.');
        }

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
        return redirect('/admincadanganbb')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $check = CadanganbbModel::find($id);

        if (!$check) {
            return redirect('/admincadanganbb')->with('error', 'Data tidak ditemukan');
        }

        try {
            CadanganbbModel::destroy($id);

            return redirect('/admincadanganbb')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admincadanganbb')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
    public function exportPDF(Request $request)
    {
        // $userOpcoId = auth()->user()->admin->opco_id;
        try {
            $admincadanganbb = CadanganbbModel::select(
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
                $admincadanganbb->where('m_cadangan_bb.opco_id', $request->opco_id);
            }

            $data = $admincadanganbb->get();

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
