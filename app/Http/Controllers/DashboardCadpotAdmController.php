<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadangandanPotensiModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardCadpotAdmController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $OpcoId = auth()->user()->admin->opco_id;
        // Breadcrumb data
        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'Dashboard Cadangan dan Potensi Bahan Baku di SIG - GHOPO Tuban',
                'list' => ['Dashboard', 'GHOPO Tuban']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'Dashboard Cadangan dan Potensi Bahan Baku di SIG - SG Rembang',
                'list' => ['Dashboard', 'SG Rembang']
            ];
        }

        // Page data
        $page = (object)[
            'title' => 'Daftar Cadangan dan Potensi Bahan Baku yang terdaftar dalam sistem'
        ];

        // Active menu identifier
        $activeMenu = 'dashboardcadpot';

        $komoditi = CadangandanPotensiModel::where('opco_id', $OpcoId)
            ->select('komoditi')
            ->distinct()
            ->get();

        $selectedKomoditi = $request->input('komoditi');
        $query = CadangandanPotensiModel::where('opco_id', $OpcoId);
        if ($selectedKomoditi) {
            $query->where('komoditi', $selectedKomoditi);
        }
        if ($OpcoId == 1) {
            // Filter data by `opco_id`
            $totalSdCadanganTon = $query->sum('sd_cadangan_ton');
            $totalValidIUP = $query->whereNotNull('masa_berlaku_iup')->count();
            $totalValidPPKH = $query->whereNotNull('masa_berlaku_ppkh')->count();

            // Chart SD/Cadangan by Komoditi for `opco_id = 1`
            $data = CadangandanPotensiModel::where('opco_id', $OpcoId)
                ->when($selectedKomoditi, function ($q) use ($selectedKomoditi) {
                    return $q->where('komoditi', $selectedKomoditi);
                })
                ->select('komoditi', CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
                ->groupBy('komoditi')
                ->orderBy('total_sd_cadangan_ton', 'desc')
                ->limit(6)
                ->get();

            // Prepare the data for the chart
            $komoditiLabels = $data->pluck('komoditi');
            $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');

            // Table Data for `opco_id = 1`
            $tableData = CadangandanPotensiModel::where('opco_id', $OpcoId)
                ->when($selectedKomoditi, function ($q) use ($selectedKomoditi) {
                    return $q->where('komoditi', $selectedKomoditi);
                })
                ->select('komoditi', 'lokasi_iup', 'sd_cadangan_ton', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'jarak')
                ->get()
                ->map(function ($item) {
                    $today = Carbon::now();

                    // Check if masa_berlaku_iup has a valid date
                    if ($item->masa_berlaku_iup) {
                        $masaBerlakuIUP = Carbon::parse($item->masa_berlaku_iup);
                        // Calculate the difference in days
                        $diffInDays = $masaBerlakuIUP->diffInDays($today, true);

                        // Set warning if it is less than or equal to 365 days (1 year left)
                        $item->warning = ($diffInDays <= 365 && $diffInDays >= 0);
                    } else {
                        // If there is no date, do not set warning
                        $item->warning = false;
                    }

                    return $item;
                });

            // Define icons for the map legend
            $iconsLegend = [
                'Cad Batugamping' => 'images/CadBatugamping.png',
                'Pot Batugamping' => 'images/PotBatugamping.png',
                'Cad Lempung' => 'images/CadLempung.png',
                'Pot Lempung' => 'images/PotLempung.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
            ];

            if ($selectedKomoditi) {
                $iconsLegend = [$selectedKomoditi => $iconsLegend[$selectedKomoditi]];
            }


            // Filter locations for the map based on `opco_id = 1`
            $locations = CadangandanPotensiModel::where('opco_id', $OpcoId)
                ->when($selectedKomoditi, function ($q) use ($selectedKomoditi) {
                    return $q->where('komoditi', $selectedKomoditi);
                })
                ->select('komoditi', 'latitude', 'longitude', 'sd_cadangan_ton', 'tipe_sd_cadangan', 'lokasi_iup', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha', 'jarak')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            return view('Admin.dashboardCadangan.index', [
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
                'iconsLegend' => $iconsLegend,
                'OpcoId' => $OpcoId,
                'komoditi' => $komoditi,
                'selectedKomoditi' => $selectedKomoditi,
            ]);
        } else if ($OpcoId == 2) {
            // Filter data by `opco_id`
            $totalSdCadanganTon = $query->sum('sd_cadangan_ton');
            $totalValidIUP = $query->whereNotNull('masa_berlaku_iup')->count();
            $totalValidPPKH = $query->whereNotNull('masa_berlaku_ppkh')->count();

            // Chart SD/Cadangan by Komoditi for `opco_id = 2`
            $data = CadangandanPotensiModel::where('opco_id', $OpcoId)
                ->when($selectedKomoditi, function ($q) use ($selectedKomoditi) {
                    return $q->where('komoditi', $selectedKomoditi);
                })
                ->select('komoditi', CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
                ->groupBy('komoditi')
                ->orderBy('total_sd_cadangan_ton', 'desc')
                ->limit(6)
                ->get();

            // Prepare the data for the chart
            $komoditiLabels = $data->pluck('komoditi');
            $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');

            // Table Data for `opco_id = 2`
            $tableData = CadangandanPotensiModel::where('opco_id', $OpcoId)
                ->when($selectedKomoditi, function ($q) use ($selectedKomoditi) {
                    return $q->where('komoditi', $selectedKomoditi);
                })
                ->select('komoditi', 'lokasi_iup', 'sd_cadangan_ton', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'jarak')
                ->get()
                ->map(function ($item) {
                    $today = Carbon::now();

                    // Check if masa_berlaku_iup has a valid date
                    if ($item->masa_berlaku_iup) {
                        $masaBerlakuIUP = Carbon::parse($item->masa_berlaku_iup);
                        // Calculate the difference in days
                        $diffInDays = $masaBerlakuIUP->diffInDays($today, true);

                        // Set warning if it is less than or equal to 365 days (2 year left)
                        $item->warning = ($diffInDays <= 365 && $diffInDays >= 0);
                    } else {
                        // If there is no date, do not set warning
                        $item->warning = false;
                    }

                    return $item;
                });

            // Define icons for the map legend
            $iconsLegend = [
                'Cad Batugamping' => 'images/CadBatugamping.png',
                'Pot Batugamping' => 'images/PotBatugamping.png',
                'Cad Lempung' => 'images/CadLempung.png',
                'Pot Lempung' => 'images/PotLempung.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
                'Pot Tras' => 'images/PotTras.png',
            ];

            if ($selectedKomoditi) {
                $iconsLegend = [$selectedKomoditi => $iconsLegend[$selectedKomoditi]];
            }


            // Filter locations for the map based on `opco_id = 2`
            $locations = CadangandanPotensiModel::where('opco_id', $OpcoId)
                ->when($selectedKomoditi, function ($q) use ($selectedKomoditi) {
                    return $q->where('komoditi', $selectedKomoditi);
                })
                ->select('komoditi', 'latitude', 'longitude', 'sd_cadangan_ton', 'tipe_sd_cadangan', 'lokasi_iup', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha', 'jarak')
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get();

            return view('Admin.dashboardCadangan.index', [
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
                'iconsLegend' => $iconsLegend,
                'OpcoId' => $OpcoId,
                'komoditi' => $komoditi,
                'selectedKomoditi' => $selectedKomoditi,
            ]);
        }
    }

    public function maps()
    {
        return view('Admin.dashboardCadangan.index');
    }
}
