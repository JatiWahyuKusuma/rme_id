@extends('layoutAdmin.template')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #map {
            height: 600px;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.js"
        integrity="sha512-QbaChpzUJcRVsOFtDhh/VZMuljqvlPRIhIXsvfREDZcdqzIKdNvAhwrgW+flSxtbxK/BFpdX1y5NSO6bSYHlOA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.53.0/apexcharts.min.css"
        integrity="sha512-w3pXofOHrtYzBYpJwC6TzPH6SxD6HLAbT/rffdkA759nCQvYi5AHy5trNWFboZnj4xtdyK0AFMBtck9eTmwybg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        var options = {
            series: [{
                data: @json($kapTonThn) // Ensure this data aligns with the colors
            }],
            chart: {
                type: 'bar',
                height: 380
            },
            title: {
                text: 'Kap(ton/thn) Bahan Baku by Komoditi',
                align: 'center',
                floating: false,
                style: {
                    fontSize: '18px',
                    fontWeight: 'bold',
                    color: '#333'
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 5,
                    borderRadiusApplication: 'end',
                    horizontal: true,
                    distributed: true, // Enable distributed colors
                }
            },
            colors: ['#9B9B9B', '#000000', '#FF0000'], // Define your colors here
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#FFFFFF']
                },
                formatter: function(val) {
                    // Format the value with a period as a thousand separator
                    return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                },
                dropShadow: {
                    enabled: false
                },
                background: {
                    enabled: false
                }
            },
            xaxis: {
                categories: @json($komoditiLabels),
                labels: {
                    formatter: function(val) {
                        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            },
            tooltip: {
                theme: 'dark',
                x: {
                    show: true
                },
                y: {
                    title: {
                        formatter: function() {
                            return 'Kap(ton/thn) = ';
                        }
                    },
                    formatter: function(value) {
                        // Format the value with a period as a thousand separator
                        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                    }
                }
            },
            legend: {
                show: false // Hide the legend
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-success text-center">
                            <div class="inner" style="font-size: 50px;"> <!-- Increase font size for value -->
                                <h3>{{ $totalKapTonThn }}</h3> <!-- Total SD/Cadangan (ton) -->
                            </div>
                            <p style="font-size: 20px; margin-top: -10px; margin-bottom: 10px;">Total Kap(ton/thn)</p>
                            <!-- Increased font size for label -->
                            <div class="icon">
                                <i class="ion ion-cube"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-warning text-center">
                            <div class="inner" style="font-size: 50px;"> <!-- Increased font size for value -->
                                <h3>{{ $unitPotensiBB }}</h3> <!-- Total Valid IUP -->
                            </div>
                            <p style="font-size: 20px; margin-top: -10px; margin-bottom: 10px;">Unit Produksi BB</p>
                            <!-- Increased font size for label -->
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <div class="small-box bg-info text-center">
                            <div class="inner" style="font-size: 50px;"> <!-- Increased font size for value -->
                                <h3>{{ $totalVendor }}</h3> <!-- Total Valid PPKH -->
                            </div>
                            <p style="font-size: 20px; margin-top: -10px; margin-bottom: 10px;">Total Vendor BB</p>
                            <!-- Increased font size for label -->
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <section class="col-lg-7 connectedSortable">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style="text-align: center; font-size: 20px; font-weight: bold;">
                                    Peta Vendor Bahan Baku
                                </div>
                                <div class="legend" style="margin-bottom: 5px; display: flex; align-items: center;">
                                    <!-- Jarak di sini diperkecil -->
                                    <h5 style="margin-right: 10px; font-weight: bold;">Komoditi : </h5>
                                    <!-- Judul bold dan geser ke kanan -->
                                    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                        @foreach ($iconsLegend as $label => $iconPath)
                                            <div style="display: flex; align-items: center;">
                                                <img src="{{ asset($iconPath) }}" alt="{{ $label }}"
                                                    style="width: 20px; height: 20px; margin-right: 5px;">
                                                <span>{{ $label }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="map"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="col-lg-5 connectedSortable">

                <!-- BAR CHART -->
                <div class="container px-7 mx-auto">
                    <div class="p-6 m-20 bg-white rounded shadow">
                        <div id="chart"></div>
                        {{-- {!! $chart->container() !!} --}}
                    </div>
                </div>
                <div class="card bg-gradient-info">
                </div>
                {{-- DETAIL TABLE --}}
                <div class="container mt-4">
                    <div class="p-6 m-20 bg-white rounded shadow" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead style="position: sticky; top: 0; background-color: white; z-index: 10;">
                                <tr>
                                    <th class="text-center">Komoditi</th>
                                    <th class="text-center">Vendor</th>
                                    <th class="text-center">Kap(ton/thn)</th>
                                    <th class="text-center">Kabupaten</th>
                                    <th class="text-center">Jarak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tableData as $data)
                                    <tr>
                                        <td>{{ $data->komoditi }}</td>
                                        <td>{{ $data->vendor }}</td>
                                        <td>{{ number_format($data->kap_ton_thn, 0, '.', '.') }}</td>
                                        <td>{{ $data->kabupaten }}</td>
                                        <td>{{ $data->jarak }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
@endsection
@push('javascript')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-7.120465639317109, 111.64157576065331], 9);

            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Data lokasi dari backend (laravel) locations dalam format JSON
            const locationsVen = @json($locationsVen);

            // Mapping komoditi ke warna
            const iconMapping = {
                'Purified Gypsum': 'images/PurifiedGypsum.png',
                'Copper Slag': 'images/CopperSlag.png',
                'Fly Ash': 'images/FlyAsh.png',
                'Pabrik Semen Indonesia Tuban': 'images/ghopotuban.png', // Icon for Tuban factory
                'Pabrik SG Rembang': 'images/sgrembang.png'
                // Add other commodities and their corresponding icons as needed
            };

            locationsVen.forEach(location => {
                if (location.latitude && location.longitude) {
                    const commodityIconUrl = iconMapping[location.komoditi] ||
                        'images/user.png'; // Use a default icon if not found
                    const commodityIcon = L.icon({
                        iconUrl: commodityIconUrl,
                        iconSize: [25, 25], // Adjust the size as needed
                        iconAnchor: [15, 30],
                        popupAnchor: [0, -30]
                    });
                    L.marker([location.latitude, location.longitude], {
                            icon: commodityIcon
                        })
                        .bindPopup(`
                <div style="font-family: Arial, sans-serif;">
                    <table style="width: 100%;">
                        <tr>
                            <td><strong> Komoditi </strong></td>
                            <td>${location.komoditi}</td>
                        </tr>
                        <tr>
                            <td><strong> Kap(ton/thn) </strong></td>
                            <td>${numberWithCommas(location.kap_ton_thn)}</td>
                        </tr>
                        <tr>
                            <td><strong> Vendor </strong></td>
                            <td>${location.vendor}</td>
                        </tr>
                        <tr>
                            <td><strong> Kabupaten </strong></td>
                            <td>${location.kabupaten}</td>
                        </tr>
                        <tr>
                            <td><strong> Jarak </strong></td>
                            <td>${location.jarak}</td>
                        </tr>
                    </table>
                </div>
            `)
                        .addTo(map);
                }
            });
            @if ($OpcoId == 1)
                const tubanIcon = L.icon({
                    iconUrl: 'images/ghopotuban.png',
                    iconSize: [50, 50], // Adjust the size as needed
                    iconAnchor: [30, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.863603138698599, 111.91686228064258], {
                    icon: tubanIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Indonesia (Persero) Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 2)
                // Tambah marker untuk Pabrik SG Rembang
                const rembangIcon = L.icon({
                    iconUrl: 'images/sgrembang.png',
                    iconSize: [50, 50], // Adjust the size as needed
                    iconAnchor: [30, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.862084537748621, 111.45844893831284], {
                    icon: rembangIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Gresik Rembang, Tbk</h5>
        </div>
    `).addTo(map);
            @endif

            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>
@endpush
