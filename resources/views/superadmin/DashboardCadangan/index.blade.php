@extends('layout.template')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #map {
            height: 685px;
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
            colors: @json($chartColors),
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
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Filter: </label>
                            <div class="col-3">
                                <select class="form-control" name="opco_id" id="opco_id">
                                    <option value="">-- Semua --</option>
                                    @foreach ($opco as $opcoItem)
                                        <option value="{{ $opcoItem->opco_id }}"
                                            {{ request('opco_id') == $opcoItem->opco_id ? 'selected' : '' }}>
                                            {{ $opcoItem->nama_opco }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Opco</small>
                            </div>
                        </div>
                    </div>
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
                                <div class="card-header" style="text-align: center; font-size: 20px; font-weight: bold;">
                                    Peta Cadangan dan Potensi Bahan Baku
                                </div>
                                <div class="legend" style="margin-bottom: 5px; display: flex; align-items: center;">
                                    <h5 style="margin-right: 10px; font-weight: bold;">Komoditi : </h5>
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
    <script>
        document.getElementById('opco_id').addEventListener('change', function() {
            let selectedOpco = this.value;
            // Redirect to the same page with query parameter ?opco_id=
            window.location.href = `?opco_id=${selectedOpco}`;
        });
    </script>

    </script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-6.956579976082929, 111.69833373298265], 10);

            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 50,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Data lokasi dari backend (laravel) locations dalam format JSON
            const locations = @json($locations);
            const iconsLegend = @json($iconsLegend);

            // Mapping komoditi ke warna
            const iconMapping = {
                'Cad Batugamping': 'images/CadBatugamping.png',
                'Cad Lempung': 'images/CadLempung.png',
                'Pot Batugamping': 'images/PotBatugamping.png',
                'Pot Pasirkuarsa': 'images/PotPasirkuarsa.png',
                'Pot Lempung': 'images/PotLempung.png',
                'Pot Tras': 'images/PotTras.png',
                'Pabrik Semen Indonesia Tuban': 'images/ghopotuban.png', // Icon for Tuban factory
                'Pabrik SG Rembang': 'images/sgrembang.png'
                // Add other commodities and their corresponding icons as needed
            };

            function getIconSize(sdCadanganTon) {
                const minSize = 10; // Ukuran minimal
                const maxSize = 25; // Ukuran maksimal
                const normalizedSize = Math.min(Math.max(sdCadanganTon * 0.02, minSize),
                    maxSize); // Normalisasi ukuran
                return normalizedSize;
            }
            // Tambahkan marker untuk setiap lokasi berdasarkan koordinat latitude dan longitude
            locations.forEach(location => {
                if (location.latitude && location.longitude) {
                    const iconSize = getIconSize(location.sd_cadangan_ton);
                    const commodityIconUrl = iconMapping[location.komoditi] ||
                        'images/user.png'; // Use a default icon if not found
                    const commodityIcon = L.icon({
                        iconUrl: commodityIconUrl,
                        iconSize: [iconSize, iconSize], // Adjust the size as needed
                        iconAnchor: [iconSize / 2, iconSize],
                        popupAnchor: [0, -iconSize]
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
                            <td><strong> SD/Cadangan (ton) </strong></td>
                            <td>${numberWithCommas(location.sd_cadangan_ton)}</td>
                        </tr>
                        <tr>
                            <td><strong> Tipe SD/Cadangan </strong></td>
                            <td>${location.tipe_sd_cadangan}</td>
                        </tr>
                        <tr>
                            <td><strong> Lokasi/IUP </strong></td>
                            <td>${location.lokasi_iup}</td>
                        </tr>
                        <tr>
                            <td><strong> Masa Berlaku IUP </strong></td>
                            <td>${location.masa_berlaku_iup}</td>
                        </tr>
                        <tr>
                            <td><strong> Masa Berlaku PPKH </strong></td>
                            <td>${location.masa_berlaku_ppkh}</td>
                        </tr>
                           <tr>
                            <td><strong>Luas (ha) </strong></td>
                            <td>${location.luas_ha}</td>
                        </tr>
                        <tr>
                            <td><strong>Jarak (km) </strong></td>
                            <td>${location.jarak}</td>
                        </tr>
                    </table>
                </div>
            `)
                        .addTo(map);
                }
            });

            @if ($OpcoId == null)
                // Admin for GHOPO Tuban (opco_id = 1), show only the Tuban icon
                const tubanIcon = L.icon({
                    iconUrl: 'images/ghopotuban.png',
                    iconSize: [50, 50],
                    iconAnchor: [30, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.8638896542228105, 111.91690249608592], {
                    icon: tubanIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Indonesia (Persero) Tbk</h5>
        </div>
    `).addTo(map);
                // Admin for SG Rembang (opco_id = 2), show only the Rembang icon
                const rembangIcon = L.icon({
                    iconUrl: 'images/sgrembang.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.862084537748621, 111.45844893831284], {
                    icon: rembangIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Gresik Rembang, Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 1)
                // Admin for GHOPO Tuban (opco_id = 1), show only the Tuban icon
                const tubanIcon = L.icon({
                    iconUrl: 'images/ghopotuban.png',
                    iconSize: [50, 50],
                    iconAnchor: [30, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.8638896542228105, 111.91690249608592], {
                    icon: tubanIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Indonesia (Persero) Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 2)
                // Admin for SG Rembang (opco_id = 2), show only the Rembang icon
                const rembangIcon = L.icon({
                    iconUrl: 'images/sgrembang.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
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
