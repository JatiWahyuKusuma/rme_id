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
        } elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa']
            ];
        }elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong']
            ];
        }elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap']
            ];
        }elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga']
            ];
        }elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang']
            ];
        }elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Vendor Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja']
            ];
        }

        $page = (object)[
            'title' => 'Daftar Vendor Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'adminvendorbb';

        // Fetch all cadpot data, but in the DataTable method, filtering is applied based on opco_id
        $adminvendorbb = VendorModel::orderByRaw("opco_id = ? DESC, opco_id ASC", [$userOpcoId])
            ->get();
        $opco = OpcoModel::all();

        return view('admin.vendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu, 'opco' => $opco]);
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

        if ($request->opco_id) {
            $adminvendorbb->where('opco_id', $request->opco_id);
        }

        return Datatables::of($adminvendorbb)
            ->addIndexColumn()
            ->addColumn('aksi', function ($adminvendorbb) use ($userOpcoId) {
                // Check if the current data's opco_id matches the user's opco_id
                if ($adminvendorbb->opco_id == $userOpcoId) {
                    $btn  = '<a href="' . url('/adminvendorbb/' . $adminvendorbb->vendor_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/adminvendorbb/' . $adminvendorbb->vendor_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/adminvendorbb/' . $adminvendorbb->vendor_id) . '">'
                        . csrf_field() . method_field('DELETE') .
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                    return $btn;
                }
                // If opco_id does not match, display no action buttons
                return '';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }



    public function create()
    {
        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban', 'Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang', 'Tambah']
            ];
        }elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban', 'Tambah']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa','Tambah']
            ];
        }elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong','Tambah']
            ];
        }elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap','Tambah']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga','Tambah']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang','Tambah']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Tambah Data Vendor Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja','Tambah']
            ];
        }

        $page = (object)[
            'title' => 'Tambah Vendor Bahan Baku baru'
        ];

        $adminvendorbb = VendorModel::all();
        $activeMenu = 'adminvendorbb';
        $opcoId = auth()->user()->admin->opco_id;

        return view('admin.vendor.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
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

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban', 'Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang', 'Detail']
            ];
        }elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban', 'Detail']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa','Detail']
            ];
        }elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong','Detail']
            ];
        }elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap','Detail']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga','Detail']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang','Detail']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Detail Data Vendor Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja','Detail']
            ];
        }

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'adminvendorbb';

        return view('admin.vendor.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $adminvendorbb = VendorModel::find($id);

        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban', 'Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang', 'Edit']
            ];
        }elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - SBI Tuban',
                'list' => ['Home', 'SBI Tuban', 'Edit']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - Semen Tonasa',
                'list' => ['Home', 'Semen Tonasa','Edit']
            ];
        }elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - SBI Narogong',
                'list' => ['Home', 'SBI Narogong','Edit']
            ];
        }elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - SBI Cilacap',
                'list' => ['Home', 'SBI Cilacap','Edit']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - SBI Lhoknga',
                'list' => ['Home', 'SBI Lhoknga','Edit']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - Semen Padang',
                'list' => ['Home', 'Semen Padang','Edit']
            ];
        }
        elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'Edit Data Vendor Bahan Baku di SIG - Semen Baturaja',
                'list' => ['Home', 'Semen Baturaja','Edit']
            ];
        }
        $page = (object)[
            'title' => ''
        ];
        if (!$adminvendorbb || $adminvendorbb->opco_id != auth()->user()->admin->opco_id) {
            return redirect('/adminvendorbb')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
        }
        $opcoId = auth()->user()->admin->opco_id;
        $activeMenu = 'adminvendorbb';

        return view('admin.vendor.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'adminvendorbb' => $adminvendorbb, 'activeMenu' => $activeMenu, 'opcoId' => $opcoId]);
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
            return redirect('/adminvendorbb')->withErrors('Anda tidak diizinkan untuk mengedit data ini.');
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
        return redirect('/adminvendorbb')->with('success', 'Data Vendor berhasil diubah');
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
