<?php

namespace App\Http\Controllers;

use App\Charts\sdCadanganChart;
use Illuminate\Http\Request;
use App\Models\CadanganDanPotensiModel; // Adjust the actual namespace

class DashboardCadpotSprAdmController extends Controller
{
    public function index(sdCadanganChart $chart)
    {
        $data['chart'] = $chart->build();
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

        // Fetch total SD Cadangan (ton)
        $totalSdCadanganTon = CadangandanPotensiModel::sum('sd_cadangan_ton');

        // Fetch total valid IUP
        $totalValidIUP = CadangandanPotensiModel::whereNotNull('masa_berlaku_iup')->count();

        // Fetch total valid PPKH
        $totalValidPPKH = CadangandanPotensiModel::whereNotNull('masa_berlaku_ppkh')->count();

        // Pass totals to the view
        return view('superadmin.DashboardCadangan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'sdCadanganTon' => number_format($totalSdCadanganTon, 0, '.', '.'), // Format as needed
            'totalberlakuIUP' => $totalValidIUP,
            'totalberlakuPPKH' => $totalValidPPKH,
            'chart' => $chart->build()
        ]);
    }
}
