<?php

namespace App\Http\Controllers;

use App\Models\VendorModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Vendor Bahan Baku di SIG - GHOPO Tuban ',
            'list' => ['Home', ' GHOPO Tuban']
        ];

        $page = (object)[
            'title' => 'Daftar Vendor Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'vendor';

        $vendor = VendorModel::all();

        return view('superadmin.vendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendor' => $vendor, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $vendors = VendorModel::select('vendor_id','opco_id', 'jarak', 'latitude', 'longitude', 'vendor', 'komoditi', 'desa', 'kecamatan', 'kabupaten', 'kap_ton_thn', 'konsumsi_ton_thn');
        if ($request->komoditi) {
            $vendors->where('komoditi', $request->komoditi);
        }

        return Datatables::of($vendors)
            ->addIndexColumn()
            ->addColumn('aksi', function ($vendor) {
                $btn  = '<a href="' . url('/vendor/' . $vendor->vendor_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/vendor/' . $vendor->vendor_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/vendor/' . $vendor->vendor_id) . '">'
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
            'title' => 'Tambah Data Vendor Bahan Baku di SIG - GHOPO Tuban',
            'list' => ['Home', 'GHOPO Tuban', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Vendor Bahan Baku baru'
        ];

        $ghopoven = VendorModel::all();
        $activeMenu = 'ghopoven';

        return view('superadmin.ghopoven.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ghopoven' => $ghopoven, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
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

        VendorModel::create([
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

        return redirect('/ghopoven')->with('success', 'Data Vendor berhasil ditambahkan');
    }

    public function show($id)
    {
        $ghopoven = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Vendor Bahan Baku',
            'list' => ['Home', 'GHOPO Tuban', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'ghopoven';

        return view('superadmin.ghopoven.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ghopoven' => $ghopoven, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $ghopoven = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Vendor Bahan Baku',
            'list' => ['Home', 'GHOPO Tuban', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'ghopoven';

        return view('superadmin.ghopoven.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ghopoven' => $ghopoven, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
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

        VendorModel::find($id)->update([
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
        return redirect('/ghopoven')->with('success', 'Data level berhasil diubah');
    }

    public function destroy($id)
    {
        $check = VendorModel::find($id);

        if (!$check) {
            return redirect('/ghopoven')->with('error', 'Datatidak ditemukan');
        }

        try {
            VendorModel::destroy($id);

            return redirect('/ghopoven')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/ghopoven')->with('error', 'Data  gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
