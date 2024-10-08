<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadangandanPotensiModel;
use Carbon\Carbon;


class DashboardCadpotSprAdmController extends Controller
{
    public function index()
    {
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


        // Card Total SD/Cadangan, IUP, DAN PPKH
        $totalSdCadanganTon = CadangandanPotensiModel::sum('sd_cadangan_ton');
        $totalValidIUP = CadangandanPotensiModel::whereNotNull('masa_berlaku_iup')->count();
        $totalValidPPKH = CadangandanPotensiModel::whereNotNull('masa_berlaku_ppkh')->count();

        // Chart SD/Cadangan by Komoditi
        $data = CadangandanPotensiModel::select('komoditi', CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
            ->groupBy('komoditi')
            ->orderBy('total_sd_cadangan_ton', 'desc')
            ->limit(6)
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');

        $tableData = CadangandanPotensiModel::select('komoditi', 'lokasi_iup', 'sd_cadangan_ton', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'jarak')
            ->get()
            ->map(function ($item) {
                $today = Carbon::now();

                // Check if masa_berlaku_iup has a valid date
                if ($item->masa_berlaku_iup) {
                    $masaBerlakuIUP = Carbon::parse($item->masa_berlaku_iup);
                    // Calculate the difference in days
                    $diffInDays = $masaBerlakuIUP->diffInDays($today, true);

                    // Set warning if it is less than or equal to 0 (expired) or less than 365 days
                    $item->warning = ($diffInDays <= 365 && $diffInDays >= 0);
                } else {
                    // If there is no date, do not set warning
                    $item->warning = false;
                }

                return $item;
            });

        $locations = CadangandanPotensiModel::select('komoditi', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('superadmin.DashboardCadangan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'sdCadanganTon' => number_format($totalSdCadanganTon, 0, '.', '.'),
            'totalberlakuIUP' => $totalValidIUP,
            'totalberlakuPPKH' => $totalValidPPKH,
            'komoditiLabels' => $komoditiLabels,
            'sdCadanganTons' => $sdCadanganTons,
            'tableData' => $tableData,
            'locations' => $locations,
        ]);
    }

    public function maps()
    {
        return view('superadmin.DashboardCadangan.index');
    }
}
