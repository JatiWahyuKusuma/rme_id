<?php

namespace App\Http\Controllers;

use App\Models\KriteriaModel;
use App\Models\OpcoModel;
use App\Models\SubKriteriaModel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubKriteriaController extends Controller
{
    public function index(Request $request)
    {
        $breadcrumb = (object) [
            'title' => 'Data Sub Kriteria Penerbitan Prioritas Perluasan Lahan',
            'list' => ['Home', 'SubKriteria']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'subkriteria';
        $subkriteria = SubKriteriaModel::all();
        $kriteria = KriteriaModel::all();
        $opco = OpcoModel::all();

        return view('superadmin.subkriteria.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'subkriteria' => $subkriteria, 'activeMenu' => $activeMenu, 'opco' => $opco, 'kriteria' => $kriteria]);
    }

    public function list(Request $request)
    {
        $subkriteria = SubKriteriaModel::select(
            'subkriteria.subkriteria_id',
            'subkriteria.kriteria_id',
            'kriteria.nama_kriteria',
            'subkriteria.nama_subkriteria',
            'subkriteria.bobot_subkriteria'
        )
            ->join('kriteria', 'kriteria.kriteria_id', '=', 'subkriteria.kriteria_id');


        if ($request->kriteria_id) {
            $subkriteria->where('subkriteria.kriteria_id', $request->kriteria_id);
        }

        return Datatables::of($subkriteria)
            ->addIndexColumn()
            ->addColumn('aksi', function ($subkriteria) {
                $btn = '<a href="' . url('/subkriteria/' . $subkriteria->subkriteria_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/subkriteria/' . $subkriteria->subkriteria_id) . '">'
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
            'title' => 'Tambah Data Sub Kriteria Penerbitan Prioritas Perluasan Lahan ',
            'list' => ['Home', 'Kriteria', 'Tambah']
        ];

        $page = (object)[
            'title' => ''
        ];

        $kriteria = KriteriaModel::all();
        $activeMenu = 'subkriteria';
        $opco = OpcoModel::all();

        return view('superadmin.subkriteria.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kriteria' => $kriteria, 'activeMenu' => $activeMenu, 'opco' => $opco]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|integer',
            'nama_subkriteria' => 'required|string',
            'bobot_subkriteria' => 'required|integer',
        ]);
        SubKriteriaModel::create([
            'kriteria_id' => $request->kriteria_id,
            'nama_subkriteria' => $request->nama_subkriteria,
            'bobot_subkriteria' => $request->bobot_subkriteria,
        ]);

        return redirect('/subkriteria')->with('success', 'Data berhasil ditambahkan');
    }


    public function edit($id)
    {
        $subkriteria = SubKriteriaModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Data Sub Kriteria',
            'list' => ['Home', 'Sub Kriteria ', 'Edit']
        ];

        $page = (object)[
            'title' => ''
        ];

        $activeMenu = 'subkriteria';

        return view('superadmin.subkriteria.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'subkriteria' => $subkriteria, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kriteria_id' => 'required|integer',
            'nama_subkriteria' => 'required|string',
            'bobot_subkriteria' => 'required|',
        ]);

        SubKriteriaModel::find($id)->update([
            'kriteria_id' => $request->kriteria_id,
            'nama_subkriteria' => $request->nama_subkriteria,
            'bobot_subkriteria' => $request->bobot_subkriteria,
        ]);
        return redirect('/subkriteria')->with('success', 'Data berhasil diubah');
    }
    public function destroy($id)
    {
        $check = SubKriteriaModel::find($id);

        if (!$check) {
            return redirect('/subkriteria')->with('error', 'Data tidak ditemukan');
        }

        try {
            SubKriteriaModel::destroy($id);

            return redirect('/kriteria')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/kriteria')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
