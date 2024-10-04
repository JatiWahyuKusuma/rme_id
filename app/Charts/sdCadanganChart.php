<?php

namespace App\Charts;

use App\Models\CadangandanPotensiModel;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class sdCadanganChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\HorizontalBar
    {
    // Retrieve unique commodities and sum their sd_cadangan_ton values
    $data = CadangandanPotensiModel::select('komoditi', \App\Models\CadangandanPotensiModel::raw('SUM(sd_cadangan_ton) as total_sd_cadangan_ton'))
        ->groupBy('komoditi') // Group by commodity
        ->orderBy('total_sd_cadangan_ton', 'desc') // Order by total descending
        // ->limit(6) // Limit the results to 6 unique commodities
        ->get();
    
        // Prepare the data for the chart
        $komoditiLabels = $data->pluck('komoditi');
        $sdCadanganTons = $data->pluck('total_sd_cadangan_ton');
         $sdCadanganTons = $data->pluck('total_sd_cadangan_ton')->map(function ($value) {
        return floatval($value);
    });
    
        // Create the horizontal bar chart
        return $this->chart->horizontalBarChart()
            ->setTitle('SD/Cadangan (Ton) by Komoditi')
            ->setColors(['#FFC107', '#D32F2F'])
            ->addData('SD Cadangan Ton', $sdCadanganTons->toArray()) // Add the summed ton data
            ->setXAxis($komoditiLabels->toArray()); // Set the komoditi as X Axis labels
    }
}
