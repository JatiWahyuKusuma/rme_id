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
        $commoditiesByOpco = CadangandanPotensiModel::query()
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


        // Card Total SD/Cadangan, IUP, DAN PPKH
        $totalSdCadanganTon = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)->sum('sd_cadangan_ton');
        $totalValidIUP = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereNotNull('masa_berlaku_iup')
            ->where('status_penyelidikan', 'Operasi Produksi')
            ->count();
        $totalValidPPKH = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)->whereNotNull('masa_berlaku_ppkh')->count();
        $totalIUPEksplorasi = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereNotNull('masa_berlaku_iup')
            ->where('status_penyelidikan', 'Eksplorasi')
            ->count();

        // Chart SD/Cadangan by Komoditi
        $data = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
            ->groupBy('komoditi')
            ->orderBy('total_sd_cadangan_ton', 'desc')
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');
        $commodityColors = [
            'Cad Batugamping' => '#000440',
            'Cad Tanah Liat' => '#002b00',
            'Pot Batugamping' => '#007DFF',
            'Pot Tanah Liat' => '#00FF00',
            'Pot Pasirkuarsa' => '#FF7D00',
            'Pot Tras' => '#7D007D',
            'Cad Tras' => '#320432',
            'Cad Pasirkuarsa' => '#8e4500',
            'Cad Agregat Basalt' => '#393839',
            'Cad Granit' => '#eb35a3',
        ];

        $chartColors = $komoditiLabels->map(function ($komoditi) use ($commodityColors) {
            return $commodityColors[$komoditi] ?? '#CCCCCC'; // Warna default jika komoditi tidak ditemukan
        })->toArray();
        $tableData = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'lokasi_iup', 'sd_cadangan_ton', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha')
            ->get()
            ->map(function ($item) {
                $today = Carbon::now();

                // Masa Berlaku IUP
                if ($item->masa_berlaku_iup) {
                    $masaBerlakuIUP = Carbon::parse($item->masa_berlaku_iup);
                    // Tandai jika tanggal kurang dari 1 tahun dari sekarang atau sudah lewat
                    $item->warning_iup = $masaBerlakuIUP->isPast() || $masaBerlakuIUP->diffInDays($today) <= 365;
                } else {
                    $item->warning_iup = false;
                }

                // Masa Berlaku PPKH
                if ($item->masa_berlaku_ppkh) {
                    $masaBerlakuPPKH = Carbon::parse($item->masa_berlaku_ppkh);
                    // Tandai jika tanggal kurang dari 1 tahun dari sekarang atau sudah lewat
                    $item->warning_ppkh = $masaBerlakuPPKH->isPast() || $masaBerlakuPPKH->diffInDays($today) <= 365;
                } else {
                    $item->warning_ppkh = false;
                }

                return $item;
            });


        // Define the icons legend dynamically based on the selected opco_id
        $iconsLegend = [];
        if ($opcoId == null) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tanah Liat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
                'Pot Tras' => 'images/PotTras.png',
                'Cad Tras' => 'images/CadTras.png',
                'Cad Pasirkuarsa' => 'images/Cadpasirkuarsa.png',
                'Cad Agregat Basalt' => 'images/CadAgregatBasalt.png',
                'Cad Granit' => 'images/CadGranit.png',
            ];
        } elseif ($opcoId == 1) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tana hLiat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
            ];
        } elseif ($opcoId == 2) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
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
        } elseif ($opcoId == 4) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tana hLiat' => 'images/PotTanahLiat.png',
                'Pot Pasirkuarsa' => 'images/PotPasirkuarsa.png',
            ];
        } elseif ($opcoId == 5) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Pot Tanah Liat' => 'images/PotTanahliat.png',
                'Cad Tana Liat' => 'images/CadTanahLiat.png',
                'Pot Tras' => 'images/PotTras.png',
            ];
        } elseif ($opcoId == 6) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tanah Liat' => 'images/PotTanahliat.png',
            ];
        } elseif ($opcoId == 7) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tanah Liat' => 'images/PotTanahliat.png',
                'Pot Tras' => 'images/PotTras.png',
            ];
        } elseif ($opcoId == 8) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tanah Liat' => 'images/PotTanahliat.png',
                'Cad Tras' => 'images/CadTras.png',
                'Cad Pasirkuarsa' => 'images/Cadpasirkuarsa.png',
                'Cad Agregat Basalt' => 'images/CadAgregatBasalt.png',
                'Cad Granit' => 'images/CadGranit.png',
            ];
        } elseif ($opcoId == 9) {
            $iconsLegend = [
                'Cad Batugamping' => 'images/Cadbatugamping.png',
                'Pot Batugamping' => 'images/PotBatugampings.png',
                'Cad Tanah Liat' => 'images/Cadtanahliat.png',
                'Pot Tanah Liat' => 'images/PotTanahliat.png',
            ];
        }



        $locations = CadangandanPotensiModel::whereIn('opco_id', $opcoIdList)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'latitude', 'longitude', 'sd_cadangan_ton', 'status_penyelidikan', 'lokasi_iup', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha', 'jarak')
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
