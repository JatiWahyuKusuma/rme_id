<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $admin = User::all();

        return view('superadmin.admin.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admin' => $admin, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $admins = User::select('id','name', 'email', 'password');
        if ($request->name) {
            $admins->where('name', $request->name);
        }

        return Datatables::of($admins)
            ->addIndexColumn()
            ->addColumn('aksi', function ($admin) {
                $btn  = '<a href="' . url('/admin/' . $admin->id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/admin/' . $admin->id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/admin/' . $admin->id) . '">'
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

        $admin = User::all();
        $activeMenu = 'admin';

        return view('superadmin.admin.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admin' => $admin, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'level_id' => 'required|integer',
            // 'opco_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect('/admin')->with('success', 'Data admin berhasil ditambahkan');
    }

    public function show($id)
    {
        $admin = User::find($id);

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
        $admin = User::find($id);

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
            // 'level_id' => 'required|integer',
            // 'opco_id' => 'required|integer',
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'nullable'
        ]);

        User::find($id)->update([
            // 'level_id' => $request->level_id,
            // 'opco_id' => $request->opco_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        return redirect('/admin')->with('success', 'Data admin berhasil diubah');
    }

    public function destroy($id)
    {
        $check = User::find($id);

        if (!$check) {
            return redirect('/admin')->with('error', 'Data admin tidak ditemukan');
        }

        try {
            User::destroy($id);

            return redirect('/admin')->with('success', 'Data admin berhasil dihapus');
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Data admin gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
