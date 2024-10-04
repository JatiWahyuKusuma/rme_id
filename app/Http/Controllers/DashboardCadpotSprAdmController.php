<?php

namespace App\Http\Controllers;

use App\Charts\sdCadanganChart;
use Illuminate\Http\Request;
use App\Models\CadanganDanPotensiModel; // Adjust the actual namespace

class DashboardCadpotSprAdmController extends Controller
{
    public function index()
    {
        // $data['chart'] = $chart->build();
        // Breadcrumb data
        $breadcrumb = (object) [
            'title' => 'DASHBOARD CADANGAN DAN POTENSI BAHAN BAKU DI SIG',
            'list' => ['Home', 'Dashboard']
        ];

        // Page data
        $page = (object)[
            'title' => 'Daftar Cadangan dan Potensi Bahan Baku yang terdaftar dalam sistem'
        ];

        // Active menu identifier
        $activeMenu = 'dashboardcadangan';


        //Card Total SD/Cadangan,IUP DAN PPKH
        $totalSdCadanganTon = CadangandanPotensiModel::sum('sd_cadangan_ton');
        $totalValidIUP = CadangandanPotensiModel::whereNotNull('masa_berlaku_iup')->count();
        $totalValidPPKH = CadangandanPotensiModel::whereNotNull('masa_berlaku_ppkh')->count();

        //Chart SD/Cadangan by Komoditi
        $data = CadangandanPotensiModel::select('komoditi', CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
            ->groupBy('komoditi')
            ->orderBy('total_sd_cadangan_ton', 'desc')
            ->limit(6) // Limit to 6 unique commodities
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');

        // Pass totals to the view
        return view('superadmin.DashboardCadangan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'sdCadanganTon' => number_format($totalSdCadanganTon, 0, '.', '.'), // Format as needed
            'totalberlakuIUP' => $totalValidIUP,
            'totalberlakuPPKH' => $totalValidPPKH,
            'komoditiLabels' =>   $komoditiLabels,
            'sdCadanganTons' =>   $sdCadanganTons,
            // 'chart' => $chart->build()
        ]);
    }
}
