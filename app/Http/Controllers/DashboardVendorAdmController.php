<?php

namespace App\Http\Controllers;

use App\Models\CadangandanPotensiModel;
use App\Models\OpcoModel;
use App\Models\VendorModel;
use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardVendorAdmController extends Controller
{
    public function index(Request $request)
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
        $opco = OpcoModel::all();

        $opcoId = $request->input('opco_id', null);
        $commoditiesByOpco = VendorModel::query()
            ->select('opco_id', 'komoditi')
            ->distinct()
            ->get()
            ->groupBy('opco_id')
            ->map(function ($items) {
                return $items->pluck('komoditi')->toArray();
            })
            ->toArray();

        // Filter valid opcoIdList dan komoditi yang sesuai
        if (is_null($opcoId)) {
            $opcoIdList = array_keys($commoditiesByOpco);
            $validCommodities = array_merge(...array_values($commoditiesByOpco));
        } else {
            $opcoIdList = [$opcoId];
            $validCommodities = $commoditiesByOpco[$opcoId] ?? [];
        }

        //Card TotalKapTon, Unit Potensi, Total Vendor
        $totalKapTonThn = VendorModel::whereIn('opco_id', $opcoIdList)->sum('kap_ton_thn');
        $unitProduksiBB = VendorModel::whereIn('opco_id', $opcoIdList)->whereNotNull('komoditi')->distinct('komoditi')->count('komoditi');
        $totalVendor = VendorModel::whereIn('opco_id', $opcoIdList)->whereNotNull('vendor')->distinct('vendor')->count('vendor');

        $data = VendorModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', VendorModel::raw('SUM(kap_ton_thn) as total_kap_ton_thn'))
            ->groupBy('komoditi')
            ->orderBy('total_kap_ton_thn', 'desc')
            ->limit(3) // Limit to 6 unique commodities
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $kapTonThn = $data->pluck('total_kap_ton_thn');
        $commodityColors = [
            'Purified Gypsum' => '#9b9b9b',
            'Copper Slag' => '#000000',
            'Fly Ash' => '#ff0000',
        ];

        $chartColors = $komoditiLabels->map(function ($komoditi) use ($commodityColors) {
            return $commodityColors[$komoditi] ?? '#CCCCCC'; // Warna default jika komoditi tidak ditemukan
        })->toArray();

        // Table Data
        $tableData = VendorModel::whereIn('opco_id', $opcoIdList)
            ->select('komoditi', 'vendor', 'kap_ton_thn', 'kabupaten', 'jarak')
            ->get();

        $iconsLegend = [];
        if ($opcoId == null) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/FlyAsh.png',
            ];
        } elseif ($opcoId == 1) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/FlyAsh.png',
            ];
        } elseif ($opcoId == 2) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/Flyash.png',
            ];
        } elseif ($opcoId == 3) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/Flyash.png',
            ];
        } elseif ($opcoId == 4) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/Flyash.png',
            ];
        } elseif ($opcoId == 5) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/Flyash.png',
            ];
        } elseif ($opcoId == 6) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/Flyash.png',
            ];
        } elseif ($opcoId == 7) {
            $iconsLegend = [
                'Purified Gypsum' => 'images/PurifiedGypsum.png',
                'Copper Slag' => 'images/CopperSlag.png',
                'Fly Ash' => 'images/Flyash.png',
            ];
        }
        $locationsVen = VendorModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'latitude', 'longitude', 'kap_ton_thn', 'vendor', 'kabupaten', 'jarak')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();


        // Pass totals to the view
        return view('Admin.dashboardVendor.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'opco' => $opco,
            'totalKapTonThn' => number_format($totalKapTonThn, 0, '.', '.'), // Format as needed
            'unitProduksiBB' => $unitProduksiBB,
            'totalVendor' => $totalVendor,
            'komoditiLabels' => $komoditiLabels,
            'kapTonThn' => $kapTonThn,
            'tableData' => $tableData,
            'locationsVen' => $locationsVen,
            'iconsLegend' => $iconsLegend,
            'OpcoId' => $opcoId,
            'chartColors' => $chartColors,
        ]);
    }

    public function maps()
    {
        return view('Admin.DashboardVendor.index');
    }
}
