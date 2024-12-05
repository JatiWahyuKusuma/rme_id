<?php

namespace App\Http\Controllers;

use App\Models\OpcoModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OpcoController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Opco',
            'list' => ['Home', 'Opco']
        ];

        $page = (object)[
            'title' => 'Daftar opco yang terdaftar dalam sistem'
        ];

        $activeMenu = 'opco';

        $opco = OpcoModel::all();

        return view('superadmin.opco.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'opco' => $opco, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $opcos = OpcoModel::select('opco_id', 'kode_opco', 'nama_opco');
        if ($request->kode_opco) {
            $opcos->where('kode_opco', $request->kode_opco);
        }

        if ($request->opco_id) {
            $opcos->where('opco_id', $request->opco_id);
        }

        return Datatables::of($opcos)
            ->addIndexColumn()
            ->addColumn('aksi', function ($opco) {
                $btn  = '<a href="' . url('/opco/' . $opco->opco_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/opco/' . $opco->opco_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/opco/' . $opco->opco_id) . '">'
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
            'title' => 'Tambah Opco',
            'list' => ['Home', 'Opco', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah opco baru'
        ];

        $opco = OpcoModel::all();
        $activeMenu = 'opco';

        return view('superadmin.opco.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'opco' => $opco, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_opco' => 'required|string|min:3|unique:m_opco',
            'nama_opco' => 'required|string|max:100'
        ]);

        OpcoModel::create([
            'kode_opco' => $request->kode_opco,
            'nama_opco' => $request->nama_opco
        ]);

        return redirect('/opco')->with('success', 'Data opco berhasil ditambahkan');
    }

    public function show($id)
    {
        $opco = OpcoModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail opco',
            'list' => ['Home', 'opco', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail opco'
        ];

        $activeMenu = 'opco';

        return view('superadmin.opco.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'opco' => $opco, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $opco = OpcoModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit opco',
            'list' => ['Home', 'opco', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit opco'
        ];

        $activeMenu = 'opco';

        return view('superadmin.opco.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'opco' => $opco, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_opco' => 'required|string',
            'nama_opco' => 'required|string'
        ]);

        OpcoModel::find($id)->update([
            'kode_opco' => $request->kode_opco,
            'nama_opco' => $request->nama_opco
        ]);
        return redirect('/opco')->with('success', 'Data opco berhasil diubah');
    }

    public function destroy($id)
    {
        $check = OpcoModel::find($id);

        if (!$check) {
            return redirect('/opco')->with('error', 'Data opco tidak ditemukan');
        }

        try {
            OpcoModel::destroy($id);

            return redirect('/opco')->with('success', 'Data opco berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/opco')->with('error', 'Data opco gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
