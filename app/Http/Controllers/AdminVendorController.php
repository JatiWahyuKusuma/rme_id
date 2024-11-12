<?php

namespace App\Http\Controllers;

use App\Models\OpcoModel;
use App\Models\VendorModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminVendorController extends Controller
{
    public function index()
    {
        $userOpcoId = auth()->user()->admin->opco_id;

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang']
            ];
        } elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban']
            ];
        }

        $page = (object)[
            'title' => 'Daftar Vendor Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'adminvendorbb';

        // $adminvendorbb = VendorModel::all();
        // Fetch all cadpot data, but in the DataTable method, filtering is applied based on opco_id
        $adminvendorbb = VendorModel::orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId])
            ->get();
        $opco = OpcoModel::all();

        return view('admin.Vendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function list(Request $request)
    {
        $userOpcoId = auth()->user()->admin->opco_id;

        $adminvendorbb = VendorModel::select(
            'vendor_id',
            'opco_id',
            'jarak',
            'latitude',
            'longitude',
            'vendor',
            'komoditi',
            'desa',
            'kecamatan',
            'kabupaten',
            'kap_ton_thn',
            'konsumsi_ton_thn'
        )->orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId]);
        // Filter data berdasarkan perusahaan pengguna (opco_id)
        // if ($userOpcoId) {
        //     $adminvendorbb->where('opco_id', $userOpcoId);
        // }

        if ($request->opco_id) {
            $adminvendorbb->where('opco_id', $request->opco_id);
        }
        // if ($request->komoditi) {
        //     $adminvendorbb->where('komoditi', $request->komoditi);
        // }

        return Datatables::of($adminvendorbb)
        ->addIndexColumn()
        ->addColumn('aksi', function ($adminvendorbb) use ($userOpcoId) {
            // Hanya tampilkan tombol jika opco_id data sama dengan opco_id pengguna yang login
            if ($adminvendorbb->opco_id == $userOpcoId) {
                $btn  = '<a href="' . url('/adminvendorbb/' . $adminvendorbb->vendor_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/adminvendorbb/' . $adminvendorbb->vendor_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/adminvendorbb/' . $adminvendorbb->vendor_id) . '">'
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
            'title' => 'Tambah Data Vendor Bahan Baku di SIG ',
            'list' => ['Home', 'Vendor', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Vendor Bahan Baku baru'
        ];

        $adminvendorbb = VendorModel::all();
        $activeMenu = 'adminvendorbb';
        $opcoId = auth()->user()->admin->opco_id;

        return view('admin.Vendor.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'jarak' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'vendor' => 'required|string',
            'komoditi' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'kap_ton_thn' => 'required',
            'konsumsi_ton_thn' => 'required|string',
        ]);
        $loggedOpcoId = auth()->user()->admin->opco_id;

        // Ensure the form's opco_id matches the logged-in user's opco_id
        if ($request->opco_id != $loggedOpcoId) {
            return redirect()->back()->withErrors('You are not authorized to add data for this Opco.');
        }

        VendorModel::create([
            'opco_id' => $request->opco_id,
            'jarak' => $request->jarak,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'vendor' => $request->vendor,
            'komoditi' => $request->komoditi,
            'desa' => $request->desa,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'kap_ton_thn' => $request->kap_ton_thn,
            'konsumsi_ton_thn' => $request->konsumsi_ton_thn,
        ]);

        return redirect('/adminvendorbb')->with('success', 'Data Vendor berhasil ditambahkan');
    }

    public function show($id)
    {
        $adminvendorbb = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Vendor Bahan Baku',
            'list' => ['Home', 'Vendor', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'adminvendorbb';

        return view('admin.Vendor.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $adminvendorbb = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Vendor Bahan Baku',
            'list' => ['Home', 'Vendor', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];
        if (!$adminvendorbb || $adminvendorbb->opco_id != auth()->user()->admin->opco_id) {
            return redirect('/adminvendorbb')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }
        $opcoId = auth()->user()->admin->opco_id;
        $activeMenu = 'adminvendorbb';

        return view('admin.Vendor.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'opco_id' => 'required|integer',
            'jarak' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'vendor' => 'required|string',
            'komoditi' => 'required|string',
            'desa' => 'required|string',
            'kecamatan' => 'required|string',
            'kabupaten' => 'required|string',
            'kap_ton_thn' => 'required',
            'konsumsi_ton_thn' => 'required|string',
        ]);
        $loggedOpcoId = auth()->user()->admin->opco_id;
        $adminvendorbb = VendorModel::find($id);

        if (!$adminvendorbb || $adminvendorbb->opco_id != $loggedOpcoId) {
            return redirect('/adminvend$adminvendorbb')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }


        // Ensure the form's opco_id matches the logged-in user's opco_id
        if ($request->opco_id != $loggedOpcoId) {
            return redirect()->back()->withErrors('You are not authorized to add data for this Opco.');
        }

        VendorModel::find($id)->update([
            'opco_id' => $request->opco_id,
            'jarak' => $request->jarak,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'vendor' => $request->vendor,
            'komoditi' => $request->komoditi,
            'desa' => $request->desa,
            'kecamatan' => $request->kecamatan,
            'kabupaten' => $request->kabupaten,
            'kap_ton_thn' => $request->kap_ton_thn,
            'konsumsi_ton_thn' => $request->konsumsi_ton_thn,
        ]);
        return redirect('/adminvendorbb')->with('success', 'Data level berhasil diubah');
    }

    public function destroy($id)
    {
        $check = VendorModel::find($id);

        if (!$check) {
            return redirect('/adminvendorbb')->with('error', 'Datatidak ditemukan');
        }

        try {
            VendorModel::destroy($id);

            return redirect('/adminvendorbb')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/adminvendorbb')->with('error', 'Data  gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
