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
        //Card TotalKapTon, Unit Potensi, Total Vendor
        $totalKapTonThn = VendorModel::sum('kap_ton_thn');
        $unitPotensiBB = VendorModel::whereNotNull('komoditi')->distinct('komoditi')->count('komoditi');
        $totalVendor = VendorModel::whereNotNull('vendor')->distinct('vendor')->count('vendor');

        $data = VendorModel::select('komoditi', VendorModel::raw('SUM(kap_ton_thn) as total_kap_ton_thn'))
            ->groupBy('komoditi')
            ->orderBy('total_kap_ton_thn', 'desc')
            ->limit(3) // Limit to 6 unique commodities
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $kapTonThn = $data->pluck('total_kap_ton_thn');

        // Table Data
        $tableData = VendorModel::select('komoditi', 'vendor', 'kap_ton_thn', 'kabupaten', 'jarak')
            ->get();

        $iconsLegend = [
            'Purified Gypsum' => 'images/PurifiedGypsum.png',
            'Copper Slag' => 'images/CopperSlag.png',
            'Fly Ash' => 'images/FlyAsh.png',
        ];
        $locationsVen = VendorModel::select('komoditi', 'latitude', 'longitude','kap_ton_thn', 'vendor', 'kabupaten', 'jarak')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();


        // Pass totals to the view
        return view('superadmin.dashboardVendor.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'totalKapTonThn' => number_format($totalKapTonThn, 0, '.', '.'), // Format as needed
            'unitPotensiBB' => $unitPotensiBB,
            'totalVendor' => $totalVendor,
            'komoditiLabels' => $komoditiLabels,
            'kapTonThn' => $kapTonThn,
            'tableData' => $tableData,
            'locationsVen' => $locationsVen,
            'iconsLegend' => $iconsLegend,
        ]);
    }

    public function maps()
    {
        return view('superadmin.DashboardVendor.index');
    }
}
