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
            'title' => 'Vendor Bahan Baku di SIG ',
            'list' => ['Home', 'Vendor']
        ];

        $page = (object)[
            'title' => 'Daftar Vendor Bahan Baku yang terdaftar dalam sistem'
        ];

        $activeMenu = 'vendorbb';

        $vendorbb = VendorModel::all();

        return view('superadmin.Vendor.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendorbb' => $vendorbb, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $vendorbb = VendorModel::select('vendor_id','opco_id', 'jarak', 'latitude', 'longitude', 'vendor', 'komoditi', 'desa', 'kecamatan', 'kabupaten', 'kap_ton_thn', 'konsumsi_ton_thn');

        // if ($request->komoditi) {
        //     $vendorbb->where('komoditi', $request->komoditi);
        // }
        if ($request->opco_id) {
            $vendorbb->where('opco_id', $request->opco_id);
        }


        return Datatables::of($vendorbb)
            ->addIndexColumn()
            ->addColumn('aksi', function ($vendorbb) {
                $btn  = '<a href="' . url('/vendorbb/' . $vendorbb->vendor_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/vendorbb/' . $vendorbb->vendor_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/vendorbb/' . $vendorbb->vendor_id) . '">'
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
            'title' => 'Tambah Data Vendor Bahan Baku di SIG ',
            'list' => ['Home', 'Vendor', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah Vendor Bahan Baku baru'
        ];

        $vendorbb = VendorModel::all();
        $activeMenu = 'vendorbb';

        return view('superadmin.Vendor.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendorbb' => $vendorbb, 'activeMenu' => $activeMenu]);
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

        return redirect('/vendorbb')->with('success', 'Data Vendor berhasil ditambahkan');
    }

    public function show($id)
    {
        $vendorbb = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Vendor Bahan Baku',
            'list' => ['Home', 'Vendor', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'vendorbb';

        return view('superadmin.Vendor.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendorbb' => $vendorbb, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $vendorbb = VendorModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Vendor Bahan Baku',
            'list' => ['Home', 'Vendor', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'vendorbb';

        return view('superadmin.Vendor.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'vendorbb' => $vendorbb, 'activeMenu' => $activeMenu]);
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
        return redirect('/vendorbb')->with('success', 'Data Vendor berhasil diubah');
    }

    public function destroy($id)
    {
        $check = VendorModel::find($id);

        if (!$check) {
            return redirect('/vendorbb')->with('error', 'Datatidak ditemukan');
        }

        try {
            VendorModel::destroy($id);

            return redirect('/vendorbb')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/vendorbb')->with('error', 'Data  gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
