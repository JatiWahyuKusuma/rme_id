<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadangandanPotensiModel;
use App\Models\OpcoModel;
use Carbon\Carbon;


class DashboardCadpotSprAdmController extends Controller
{
    public function index(Request $request)
    {
        // Breadcrumb data
        $breadcrumb = (object) [
            'title' => 'DASHBOARD CADANGAN DAN POTENSI BAHAN BAKU DI SIG',
            'list' => ['Home', 'Dashboard']
        ];

        // Page data
        $page = (object)[
            'title' => ''
        ];

        // Active menu identifier
        $activeMenu = 'dashboardcadangan';

        $opcoId = $request->input('opco_id', null);
        $opco = OpcoModel::all();
        $commoditiesByOpco = [
            1 => ['Cad Batugamping', 'Pot Batugamping', 'Cad Tanah Liat', 'Pot Tanah Liat', 'Pot Pasirkuarsa'],
            2 => ['Cad Batugamping', 'Pot Batugamping', 'Cad Tanah Liat', 'Pot Tanah Liat', 'Pot Pasirkuarsa', 'Pot Tras'],
            3 => ['Cad Batugamping', 'Cad Tanah Liat', 'Pot Tanah Liat', 'Pot Pasirkuarsa']
        ];
        if (empty($opcoId)) {
            $opcoIdList = [1, 2, 3];
            $validCommodities = array_merge($commoditiesByOpco[1], $commoditiesByOpco[2], $commoditiesByOpco[3]);
        } else {
            $opcoIdList = [$opcoId];
            $validCommodities = $commoditiesByOpco[$opcoId];
        }


        // Get list of valid opco IDs to filter
        if (empty($opcoId)) {
            $opcoIdList = [1, 2, 3];
            $validCommodities = array_merge($commoditiesByOpco[1], $commoditiesByOpco[2], $commoditiesByOpco[3]);
        } else {
            $opcoIdList = [$opcoId];
            $validCommodities = $commoditiesByOpco[$opcoId];
        }


        // Card Total SD/Cadangan, IUP, DAN PPKH
        $totalSdCadanganTon = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)->sum('sd_cadangan_ton');
        $totalValidIUP = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)->whereNotNull('masa_berlaku_iup')->count();
        $totalValidPPKH = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)->whereNotNull('masa_berlaku_ppkh')->count();
        $totalIUPEksplorasi = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->where('status_penyelidikan', 'Eksplorasi Rinci')
            ->count();

        // Chart SD/Cadangan by Komoditi
        $data = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
            ->groupBy('komoditi')
            ->orderBy('total_sd_cadangan_ton', 'desc')
            ->limit(6)
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');

        if ($opcoId == null) {
            $chartColors = ['#007DFF', '#000440', '#00FF00', '#FF7D00', '#002b00', '#7D007D']; //All Opco
        } elseif ($opcoId == 1) {
            $chartColors = ['#007DFF', '#000440', '#00FF00', '#002b00', '#FF7D00']; // GHOPO Tuban
        } else if ($opcoId == 2) {
            $chartColors = ['#007DFF', '#000440', '#00FF00', '#FF7D00', '#002b00', '#7D007D']; //SG Rembang
        } else if ($opcoId == 3) {
            $chartColors = ['#000440', '#00FF00', '#FF7D00', '#002b00'];
        }

        $tableData = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'lokasi_iup', 'sd_cadangan_ton', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'jarak')
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
        // Define the icons legend dynamically based on the selected opco_id
        $iconsLegend = [];
        if ($opcoId == null) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugamping.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tanah Liat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
                'Pot Tras' => 'images/PotTras.png',
            ];
        } elseif ($opcoId == 1) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugamping.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tana hLiat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
            ];
        } elseif ($opcoId == 2) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugamping.png',
                'Cad Tanah Liat' => 'images/CadTanahLiat.png',
                'Pot Tanah Liat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
                'Pot Tras' => 'images/PotTras.png',
            ];
        } elseif ($opcoId == 3) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Cad Tanah Liat' => 'images/CadTanahLiat.png',
                'Pot Tanah Liat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
            ];
        }

        $locations = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'latitude', 'longitude', 'sd_cadangan_ton', 'tipe_sd_cadangan', 'lokasi_iup', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha', 'jarak')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('superadmin.DashboardCadangan.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'opco' => $opco,
            'sdCadanganTon' => number_format($totalSdCadanganTon, 0, '.', '.'),
            'totalberlakuIUP' => $totalValidIUP,
            'totalberlakuPPKH' => $totalValidPPKH,
            'totalEksplorasi' => $totalIUPEksplorasi,
            'komoditiLabels' => $komoditiLabels,
            'sdCadanganTons' => $sdCadanganTons,
            'tableData' => $tableData,
            'locations' => $locations,
            'iconsLegend' => $iconsLegend,
            'OpcoId' => $opcoId,
            'chartColors' => $chartColors,
        ]);
    }

    public function maps()
    {
        return view('superadmin.DashboardCadangan.index');
    }
}
