<?php

namespace App\Http\Controllers;

use App\Models\VendorModel;
use Illuminate\Http\Request;

class DashboardVendorSprAdmController extends Controller
{
    public function index()
    {
        // Breadcrumb data
        $breadcrumb = (object) [
            'title' => 'DASHBOARD VENDOR BAHAN BAKU DI SIG',
            'list' => ['Home', 'Dashboard']
        ];

        // Page data
        $page = (object)[
            'title' => 'Daftar Cadangan dan Potensi Bahan Baku yang terdaftar dalam sistem'
        ];

        // Active menu identifier
        $activeMenu = 'dashboardvendor';

        // Fetch total SD Cadangan (ton)
        $totalKapTonThn = VendorModel::sum('kap_ton_thn');

        // Fetch total unique komoditi
        $unitPotensiBB = VendorModel::whereNotNull('komoditi')->distinct('komoditi')->count('komoditi');

        // Fetch total unique vendor
        $totalVendor = VendorModel::whereNotNull('vendor')->distinct('vendor')->count('vendor');

        // Pass totals to the view
        return view('superadmin.dashboardVendor.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'totalKapTonThn' => number_format($totalKapTonThn, 0, '.', '.'), // Format as needed
            'unitPotensiBB' => $unitPotensiBB,
            'totalVendor' => $totalVendor,
        ]);
    }
}
