<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use Illuminate\Http\Request;
use App\Models\OpcoModel;
use App\Models\SubKriteriaModel;
use Yajra\DataTables\DataTables;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Data Kriteria Penerbitan Prioritas Perluasan Lahan',
            'list' => ['Home', 'Kriteria']
        ];

        $page = (object)[
            'title' => 'Daftar Kriteria yang terdaftar dalam sistem'
        ];

        $activeMenu = 'kriteria';
        $kriteria = KriteriaModel::all();
        $opco = OpcoModel::all();

        return view('superadmin.kriteria.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function list(Request $request)
    {

        $kriteria = KriteriaModel::select('kriteria_id', 'nama_kriteria', 'jenis_kriteria', 'bobot_kriteria');

        if ($request->kriteria_id) {
            $kriteria->where('kriteria_id', $request->kriteria_id);
        }
        return Datatables::of($kriteria)
            ->addIndexColumn()
            ->addColumn('aksi', function ($kriteria) {
                $btn = '<a href="' . url('/kriteria/' . $kriteria->kriteria_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kriteria/' . $kriteria->kriteria_id) . '">'
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
            'title' => 'Tambah Data Kriteria Penerbitan Prioritas Perluasan Lahan ',
            'list' => ['Home', 'Kriteria', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah data kriteria Bahan Baku baru'
        ];

        $kriteria = KriteriaModel::all();
        $activeMenu = 'kriteria';
        $opco = OpcoModel::all();

        return view('superadmin.Kriteria.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string',
            'jenis_kriteria' => 'nullable|in:Benefit,Cost',
            'bobot_kriteria' => 'nullable|',
        ]);
        KriteriaModel::create([
            'nama_kriteria' => $request->nama_kriteria,
            'jenis_kriteria' => $request->jenis_kriteria,
            'bobot_kriteria' => $request->bobot_kriteria,

        ]);

        return redirect('/kriteria')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $kriteria = SubKriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Data Kriteria Penerbitan Prioritas Perluasan Lahan',
            'list' => ['Home', 'Kriteria ', 'Detail']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'kriteria';

        return view('superadmin.subkriteria.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $kriteria = KriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Cadangan Bahan Baku',
            'list' => ['Home', 'Cadangan ', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'kriteria';

        return view('superadmin.kriteria.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kriteria' => 'required|string',
            'jenis_kriteria' => 'nullable|in:Benefit,Cost',
            'bobot_kriteria' => 'nullable|',
        ]);

        KriteriaModel::find($id)->update([
            'nama_kriteria' => $request->nama_kriteria,
            'jenis_kriteria' => $request->jenis_kriteria,
            'bobot_kriteria' => $request->bobot_kriteria,
        ]);
        return redirect('/kriteria')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $check = KriteriaModel::find($id);

        if (!$check) {
            return redirect('/kriteria')->with('error', 'Data tidak ditemukan');
        }

        try {
            KriteriaModel::destroy($id);

            return redirect('/kriteria')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kriteria')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
