@extends('layout.template')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #map {
            height: 730px;
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
                data: @json($sdCadanganTons) // Ensure this data aligns with the colors
            }],
            chart: {
                type: 'bar',
                height: 380
            },
            title: {
                text: 'SD/Cadangan dan Potensi Bahan Baku by Komoditi',
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
            colors: ['#007DFF', '#00098E', '#00FF00', '#FF7D00', '#009600', '#7D007D'], // Define your colors here
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#000000']
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
                min: 1000000,
                max: 3500000000, // Set the minimum value to 1,000,000
                // Ensure this matches the data length
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
                            return 'SD/Cadangan (ton) = ';
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
                                <h3>{{ $sdCadanganTon }}</h3> <!-- Total SD/Cadangan (ton) -->
                            </div>
                            <p style="font-size: 20px; margin-top: -10px; margin-bottom: 10px;">Total SD/Cadangan (ton)</p>
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
                                <h3>{{ $totalberlakuIUP }}</h3> <!-- Total Valid IUP -->
                            </div>
                            <p style="font-size: 20px; margin-top: -10px; margin-bottom: 10px;">Total IUP</p>
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
                                <h3>{{ $totalberlakuPPKH }}</h3> <!-- Total Valid PPKH -->
                            </div>
                            <p style="font-size: 20px; margin-top: -10px; margin-bottom: 10px;">Total PPKH</p>
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
                                <div class="card-header" style="text-align: center">Peta Cadangan dan Potensi Bahan Baku </div>
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
                            <thead>
                                <tr>
                                    <th class="text-center">Komoditi</th>
                                    <th class="text-center">Lokasi IUP</th>
                                    <th class="text-center">SD/Cadangan (ton)</th>
                                    <th class="text-center">Masa Berlaku IUP</th>
                                    <th class="text-center">Masa Berlaku PPKH</th>
                                    <th class="text-center">Jarak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tableData as $data)
                                    <tr>
                                        <td>{{ $data->komoditi }}</td>
                                        <td>{{ $data->lokasi_iup }}</td>
                                        <td>{{ number_format($data->sd_cadangan_ton, 0, '.', '.') }}</td>
                                        <td class="{{ $data->warning ? 'bg-warning' : '' }}">
                                            {{ $data->masa_berlaku_iup }}
                                        </td>
                                        <td>{{ $data->masa_berlaku_ppkh }}</td>
                                        <td>{{ $data->jarak }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <style>
                    .bg-warning {
                        background-color: yellow;
                        /* or any other color you prefer */
                    }
                </style>
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
        const map = L.map('map').setView([-5.129541583080711, 113.62957770241515], 10);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 50,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Data lokasi dari backend (laravel) locations dalam format JSON
        const locations = @json($locations);

        // Mapping komoditi ke warna
        const iconMapping = {
            'Cad Batugamping': 'images/CadBatugamping.png',
            'Cad Lempung': 'images/CadLempung.png',
            'Pot Batugamping': 'images/PotBatugamping.png',
            'Pot Pasirkuarsa': 'images/PotPasirkuarsa.png',
            'Pot Lempung': 'images/PotLempung.png',
            'Pot Tras': 'images/PotTras.png',
            // Add other commodities and their corresponding icons as needed
        };

        // Tambahkan marker untuk setiap lokasi berdasarkan koordinat latitude dan longitude
        locations.forEach(location => {
            if (location.latitude && location.longitude) {
                const commodityIconUrl = iconMapping[location.komoditi] ||
                'images/user.png'; // Use a default icon if not found
                const commodityIcon = L.icon({
                    iconUrl: commodityIconUrl,
                    iconSize: [30, 30], // Adjust the size as needed
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([location.latitude, location.longitude], {
                        icon: commodityIcon
                    })
                    .bindPopup(`<strong>Komoditi:</strong> ${location.komoditi}`)
                    .addTo(map);
            }
        });
    </script>
@endpush
