<?php

namespace App\Http\Controllers;

use App\Models\CadangandanPotensiModel;
use App\Models\User;
use Illuminate\Http\Request;

class RiwayatCadpotSprAdmController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Riwayat Cadangan dan Potensi di SIG',
            'list' => ['Home', 'Riwayat']
        ];

        $page = (object) [
            'title' => 'Riwayat Cadangan dan Potensi'
        ];

        $activeMenu = 'riwayatcadpot';

        // Fetch all cadpot entries, order by last updated time (descending)
        $cadpot = CadangandanPotensiModel::orderBy('updated_at', 'desc')->get();

        return view('superadmin.RiwayatCadangan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'cadpot' => $cadpot,
            'activeMenu' => $activeMenu
        ]);
    }

    // Add an update function to save changes and track updates
    public function update(Request $request, $id)
    {
        $cadpot = CadangandanPotensiModel::findOrFail($id);
        $cadpot->update($request->all()); // Mass update

        return redirect()->route('riwayat.index')
            ->with('success', 'Data updated successfully at ' . now());
    }
}
