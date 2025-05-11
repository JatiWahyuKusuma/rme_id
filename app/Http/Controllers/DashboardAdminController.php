<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CadanganbbModel;
use Carbon\Carbon;
use App\Models\OpcoModel;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    public function index(Request $request)
    {

        // Breadcrumb data
        if (auth()->user()->admin->opco_id === 1) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - GHOPO TUBAN',
                'list' => ['Home', 'GHOPO Tuban', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 2) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SG REMBANG',
                'list' => ['Home', 'SG Rembang', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 3) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SBI TUBAN',
                'list' => ['Home', 'SBI Tuban', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 4) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SEMEN TONASA',
                'list' => ['Home', 'Semen Tonasa', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 5) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SBI NAROGONG',
                'list' => ['Home', 'SBI Narogong', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 6) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SBI CILACAP',
                'list' => ['Home', 'SBI Cilacap', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 7) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SBI LHOKNGA',
                'list' => ['Home', 'SBI Lhoknga', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 8) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SEMEN PADANG',
                'list' => ['Home', 'Semen Padang', 'Dashboard']
            ];
        } elseif (auth()->user()->admin->opco_id === 9) {
            $breadcrumb = (object) [
                'title' => 'DASHBOARD CADANGAN BAHAN BAKU DI SIG - SEMEN BATURAJA',
                'list' => ['Home', 'Semen Baturaja', 'Dashboard']
            ];
        }

        // Page data
        $page = (object)[
            'title' => ''
        ];

        // Active menu identifier
        $activeMenu = 'dashboardcad';

        $opcoId = $request->input('opco_id', null);
        $opco = OpcoModel::all();
        $lokasiIup = $request->input('lokasi_iup', null);
        $commoditiesByOpco = CadanganbbModel::query()
            ->select('opco_id', 'komoditi')
            ->distinct()
            ->get()
            ->groupBy('opco_id')
            ->map(function ($items) {
                return $items->pluck('komoditi')->toArray();
            })
            ->toArray();

        // Get distinct lokasi_iup for filter options
        $lokasiOptions = CadanganbbModel::query()
            ->when($opcoId, function ($query) use ($opcoId) {
                $query->where('opco_id', $opcoId);
            })
            ->select('lokasi_iup')
            ->distinct()
            ->orderBy('lokasi_iup')
            ->pluck('lokasi_iup')
            ->filter()
            ->toArray();


        // Filter valid opcoIdList dan komoditi yang sesuai
        if (is_null($opcoId)) {
            $opcoIdList = array_keys($commoditiesByOpco);
            $validCommodities = array_merge(...array_values($commoditiesByOpco));
        } else {
            $opcoIdList = [$opcoId];
            $validCommodities = $commoditiesByOpco[$opcoId] ?? [];
        }

        // Base query with filters
        $baseQuery = CadanganbbModel::whereIn('opco_id', $opcoIdList)
            ->when($lokasiIup, function ($query) use ($lokasiIup) {
                $query->where('lokasi_iup', $lokasiIup);
            });


        // Card Total SD/Cadangan, IUP, DAN PPKH
        $totalSdCadanganTon = (clone $baseQuery)->sum('sd_cadangan_ton');
        $totalValidIUP = (clone $baseQuery)
            ->whereNotNull('masa_berlaku_iup')
            ->where('status_penyelidikan', 'Operasi Produksi')
            ->count();
        $totalValidPPKH = (clone $baseQuery)->whereNotNull('masa_berlaku_ppkh')->count();
        $totalIUPEksplorasi = (clone $baseQuery)
            ->whereNotNull('masa_berlaku_iup')
            ->where('status_penyelidikan', 'Eksplorasi')
            ->count();

        // Chart SD/Cadangan by Komoditi
        $data = (clone $baseQuery)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', CadanganbbModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
            ->groupBy('komoditi')
            ->orderBy('total_sd_cadangan_ton', 'desc')
            ->get();

        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');
        $commodityColors = [
            'Batugamping' => '#000440',
            'Tanah Liat' => '#002b00',
            'Tras' => '#320432',
            'Pasirkuarsa' => '#8e4500',
            'Agregat Basalt' => '#393839',
            'Granit' => '#eb35a3',
        ];

        $chartColors = $komoditiLabels->map(function ($komoditi) use ($commodityColors) {
            return $commodityColors[$komoditi] ?? '#CCCCCC';
        })->toArray();

        $tableData = (clone $baseQuery)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'lokasi_iup', 'sd_cadangan_ton', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha')
            ->get()
            ->map(function ($item) {
                $today = Carbon::now();

                // Masa Berlaku IUP
                if ($item->masa_berlaku_iup) {
                    $masaBerlakuIUP = Carbon::parse($item->masa_berlaku_iup);
                    $item->warning_iup = $masaBerlakuIUP->isPast() || $masaBerlakuIUP->diffInDays($today) <= 365;
                } else {
                    $item->warning_iup = false;
                }

                // Masa Berlaku PPKH
                if ($item->masa_berlaku_ppkh) {
                    $masaBerlakuPPKH = Carbon::parse($item->masa_berlaku_ppkh);
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
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
                'Tras' => 'images/CadTras.png',
                'Pasirkuarsa' => 'images/Cadpasirkuarsa.png',
                'Agregat Basalt' => 'images/CadAgregatBasalt.png',
                'Granit' => 'images/CadGranit.png',
            ];
        } elseif ($opcoId == 1) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
            ];
        } elseif ($opcoId == 2) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/CadTanahLiat.png',
            ];
        } elseif ($opcoId == 3) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/CadTanahLiat.png',
            ];
        } elseif ($opcoId == 4) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
            ];
        } elseif ($opcoId == 5) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tana Liat' => 'images/CadTanahLiat.png',
            ];
        } elseif ($opcoId == 6) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
            ];
        } elseif ($opcoId == 7) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
            ];
        } elseif ($opcoId == 8) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
                'Tras' => 'images/CadTras.png',
                'Pasirkuarsa' => 'images/Cadpasirkuarsa.png',
                'Agregat Basalt' => 'images/CadAgregatBasalt.png',
                'Granit' => 'images/CadGranit.png',
            ];
        } elseif ($opcoId == 9) {
            $iconsLegend = [
                'Batugamping' => 'images/Cadbatugamping.png',
                'Tanah Liat' => 'images/Cadtanahliat.png',
            ];
        }

        $locations = (clone $baseQuery)
            ->whereIn('komoditi', $validCommodities)
            ->select('komoditi', 'latitude', 'longitude', 'sd_cadangan_ton', 'status_penyelidikan', 'lokasi_iup', 'masa_berlaku_iup', 'masa_berlaku_ppkh', 'luas_ha', 'jarak')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();


        return view('Admin.Dashboard.index', [
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
            'lokasiOptions' => $lokasiOptions,
        ]);
    }

    public function maps()
    {
        return view('Admin.Dashboard.index');
    }
}
