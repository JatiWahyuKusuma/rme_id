<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar admin',
            'list' => ['Home', 'admin']
        ];

        $page = (object)[
            'title' => 'Daftar admin yang terdaftar dalam sistem'
        ];

        $activeMenu = 'admin';

        $admin = AdminModel::all();

        return view('superadmin.admin.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admin' => $admin, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $admins = AdminModel::select('admin_id', 'level_id','opco_id', 'nama', 'email', 'password');
        if ($request->nama) {
            $admins->where('nama', $request->nama);
        }

        return Datatables::of($admins)
            ->addIndexColumn()
            ->addColumn('aksi', function ($admin) {
                $btn  = '<a href="' . url('/admin/' . $admin->admin_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/' . $admin->admin_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/' . $admin->admin_id) . '">'
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
            'title' => 'Tambah admin',
            'list' => ['Home', 'admin', 'Tambah']
        ];

        $page = (object)[
            'title' => 'Tambah admin baru'
        ];

        $admin = AdminModel::all();
        $activeMenu = 'admin';

        return view('superadmin.admin.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admin' => $admin, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'level_id' => 'required|integer',
            'opco_id' => 'required|integer',
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        AdminModel::create([
            'level_id' => $request->level_id,
            'opco_id' => $request->opco_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'opco' =>$request->opco,
            'password' => $request->password,
        ]);

        return redirect('/admin')->with('success', 'Data admin berhasil ditambahkan');
    }

    public function show($id)
    {
        $admin = AdminModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail admin',
            'list' => ['Home', 'admin', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail admin'
        ];

        $activeMenu = 'admin';

        return view('superadmin.admin.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admin' => $admin, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
    {
        $admin = AdminModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Edit admin',
            'list' => ['Home', 'admin', 'Edit']
        ];

        $page = (object)[
            'title' => 'Edit admin'
        ];

        $activeMenu = 'admin';

        return view('superadmin.admin.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admin' => $admin, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'level_id' => 'required|integer',
            'opco_id' => 'required|integer',
            'nama' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable'
        ]);

        AdminModel::find($id)->update([
            'level_id' => $request->level_id,
            'opco_id' => $request->opco_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'opco' =>$request->opco,
            'password' => $request->password,
        ]);
        return redirect('/admin')->with('success', 'Data admin berhasil diubah');
    }

    public function destroy($id)
    {
        $check = AdminModel::find($id);

        if (!$check) {
            return redirect('/admin')->with('error', 'Data admin tidak ditemukan');
        }

        try {
            AdminModel::destroy($id);

            return redirect('/admin')->with('success', 'Data admin berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Data admin gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
