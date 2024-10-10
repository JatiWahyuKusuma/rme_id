<?php

namespace App\Http\Controllers;

use App\Models\VendorModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardVendorAdmController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $OpcoId = auth()->user()->admin->opco_id;
        // Breadcrumb data
        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Dashboard Vendor Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Home', 'GHOPO Tuban']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Dashboard Vendor Bahan Baku di SIG - SG Rembang',
                'list' => ['Home', 'SG Rembang']
            ];
        }
        // Page data
        $page = (object)[
            'title' => 'Daftar  Bahan Baku yang terdaftar dalam sistem'
        ];

        // Active menu identifier
        $activeMenu = 'dashboardvendorbb';
        if ($OpcoId == 1) {


            //Card TotalKapTon, Unit Potensi, Total Vendor
            $totalKapTonThn = VendorModel::where('opco_id', 1)->sum('kap_ton_thn');
            $unitPotensiBB = VendorModel::where('opco_id', 1)->whereNotNull('komoditi')->distinct('komoditi')->count('komoditi');
            $totalVendor = VendorModel::where('opco_id', 1)->whereNotNull('vendor')->distinct('vendor')->count('vendor');

            $data = VendorModel::where('opco_id', 1)
                ->select('komoditi', VendorModel::raw('SUM(kap_ton_thn) as total_kap_ton_thn'))
                ->groupBy('komoditi')
                ->orderBy('total_kap_ton_thn', 'desc')
                ->limit(3) // Limit to 6 unique commodities
                ->get();

            // Prepare the data for the chart
            $komoditiLabels = $data->pluck('komoditi');
            $kapTonThn = $data->pluck('total_kap_ton_thn');

            // Table Data
            $tableData = VendorModel::where('opco_id', 1)
                ->select('komoditi', 'vendor', 'kap_ton_thn', 'kabupaten', 'jarak')
                ->get();

            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/FlyAsh.png',
            ];
            $locationsVen = VendorModel::where('opco_id', 1)
                ->select('komoditi', 'latitude', 'longitude', 'kap_ton_thn', 'vendor', 'kabupaten', 'jarak')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();


            // Pass totals to the view
            return view('Admin.dashboardVendor.index', [
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
                'OpcoId' => $OpcoId,
            ]);
        } else if ($OpcoId == 2) {
            //Card TotalKapTon, Unit Potensi, Total Vendor
            $totalKapTonThn = VendorModel::where('opco_id', 2)->sum('kap_ton_thn');
            $unitPotensiBB = VendorModel::where('opco_id', 2)->whereNotNull('komoditi')->distinct('komoditi')->count('komoditi');
            $totalVendor = VendorModel::where('opco_id', 2)->whereNotNull('vendor')->distinct('vendor')->count('vendor');

            $data = VendorModel::where('opco_id', 2)
                ->select('komoditi', VendorModel::raw('SUM(kap_ton_thn) as total_kap_ton_thn'))
                ->groupBy('komoditi')
                ->orderBy('total_kap_ton_thn', 'desc')
                ->limit(3) // Limit to 6 unique commodities
                ->get();

            // Prepare the data for the chart
            $komoditiLabels = $data->pluck('komoditi');
            $kapTonThn = $data->pluck('total_kap_ton_thn');

            // Table Data
            $tableData = VendorModel::where('opco_id', 2)
                ->select('komoditi', 'vendor', 'kap_ton_thn', 'kabupaten', 'jarak')
                ->get();

            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/FlyAsh.png',
            ];
            $locationsVen = VendorModel::where('opco_id', 2)
                ->select('komoditi', 'latitude', 'longitude', 'kap_ton_thn', 'vendor', 'kabupaten', 'jarak')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();


            // Pass totals to the view
            return view('Admin.dashboardVendor.index', [
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
                'OpcoId' => $OpcoId,
            ]);
        }
    }

    public function maps()
    {
        return view('Admin.DashboardVendor.index');
    }
}
