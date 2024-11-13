@extends('layout.template')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #map {
            height: 680px;
        }


        .row {
            margin: auto;
        }

        .form-group.row {
            margin-top: 20px;
        }

        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color: rgb(46, 46, 46);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
            colors: @json($chartColors), // Define your colors here
            dataLabels: {
                enabled: false,
                style: {
                    colors: ['#697565'],
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
        <div class="card card-outline card-primary">
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
                    <div class="col-lg-4 col-6" style="margin-top: 30px;">
                        <div class="small-box bg-success" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="95" height="95" x="0" y="0"
                                        viewBox="0 0 203.333 203.333" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M203.333 104.983v82.451a5 5 0 0 1-5 5H5a5 5 0 0 1-5-5v-58.34a5 5 0 0 1 2.768-4.474l48.333-24.111a5 5 0 0 1 7.232 4.474v16.029l29.597-14.764V57.416a5 5 0 0 1 5-5h9.074a5 5 0 0 1 5 5v63.428l33.021-16.472 2.044-88.589a5 5 0 0 1 4.999-4.885h21.797a5.001 5.001 0 0 1 4.999 4.885l2.186 94.729 20.051-10.002a5 5 0 0 1 7.232 4.473zM35.078 151.969H21.553v19.006h13.525v-19.006zm36.625 0H58.178v19.006h13.525v-19.006zm36.626 0H94.804v19.006h13.525v-19.006zm36.626 0H131.43v19.006h13.525v-19.006z"
                                                fill="#298a3f" opacity="1" data-original="#298a3f" class=""></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $totalKapTonThn }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Total Kap(ton/thn)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6" style="margin-top: 30px;">
                        <div class="small-box bg-warning" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="105" height="105" x="0" y="0"
                                        viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                        class="">
                                        <g>
                                            <rect width="56" height="7" x="4" y="22" rx="2" fill="#d9a406"
                                                opacity="1" data-original="#d9a406" class=""></rect>
                                            <path
                                                d="M41.08 49c-.658 4.096 2.685 8.048 6.92 8 6.23.037 9.366-7.738 4.87-12.02-3.924-3.99-11.115-1.527-11.79 4.02zM48 51c-1.314-.026-1.313-1.975 0-2 1.314.025 1.313 1.975 0 2zM16 43c-3.846-.028-7.03 3.205-7 7 .241 8.67 12.487 9.496 13.92 1 .658-4.097-2.685-8.048-6.92-8zm0 8c-1.314-.026-1.313-1.975 0-2 1.314.025 1.313 1.975 0 2z"
                                                fill="#d9a406" opacity="1" data-original="#d9a406" class=""></path>
                                            <path
                                                d="M8.99 44.36c5.643-6.96 16.9-2.25 15.95 6.64h14.12c-.1-.7-.07-1.676.05-2.36 1.039-7.607 11.132-10.383 15.9-4.27L57.46 31H6.54zM54.16 20l-2.13-3.1c.127-.22-5.106-2.578-5.26-2.71-1.65.636-5.302 1.74-7.02 2.33l-.525.673c-.811 1.028-2.379-.198-1.576-1.233l.651-.83c.192-.259.253-.273.53-.41l3.53-1.16c.376-.12 1.734-.552 2.09-.68l-5.18-5.56a.982.982 0 0 0-1.06-.26l-8.53 3.02c-.45 1.694-1.347 5.912-1.9 7.61l-.06.11-1.36 2.2h27.8zM25.99 16.78c.382-1.536 1.35-5.524 1.71-7.01l-2.8-2.51c-.21-.2-.5-.29-.79-.25l-4.57.57c-.33.04-.62.24-.77.54l-2.19 4.31-5.69 3.51c-.18.12-.32.29-.4.49L9.1 20h14.91z"
                                                fill="#d9a406" opacity="1" data-original="#d9a406" class=""></path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $unitProduksiBB }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Unit Produksi BB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-6" style="margin-top: 30px;">
                        <div class="small-box bg-info" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="95" height="95" x="0" y="0"
                                        viewBox="0 0 682.667 682.667" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g>
                                            <defs>
                                                <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                                    <path d="M0 512h512V0H0Z" fill="#148a9d" opacity="1"
                                                        data-original="#148a9d" class=""></path>
                                                </clipPath>
                                            </defs>
                                            <g clip-path="url(#a)" transform="matrix(1.33333 0 0 -1.33333 0 682.667)">
                                                <path
                                                    d="M0 0v-50.214h58.001V0A92.09 92.09 0 0 0 29-4.66 92.088 92.088 0 0 0 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(227 216.212)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0c-21.653-11.654-36.407-34.533-36.407-60.799v-27h54.999v66.89A93.195 93.195 0 0 0 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(178.408 253.797)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0c0 26.265-14.755 49.145-36.407 60.799A93.22 93.22 0 0 0-54.999 39.89V-27H0Z"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(370 192.998)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0h-220.141c-4.527-12.768-14.662-22.902-27.429-27.43v-18.561h275v18.561C14.662-22.903 4.526-12.768 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(367.57 45.992)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0c0 34.433-28.014 62.446-62.447 62.446-34.433 0-62.447-28.013-62.447-62.446 0-34.433 28.014-62.446 62.447-62.446C-28.014-62.446 0-34.433 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(318.447 303.999)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0h-482.015c-8.284 0-15-6.716-15-15 0-6.899 4.664-12.695 11.007-14.445v-91.552c0-8.284 6.716-15 15-15h64v30.991c0 8.284 6.716 15 15 15 8.271 0 15 6.729 15 15 0 8.284 6.716 15 15 15h245c8.284 0 15-6.716 15-15 0-8.271 6.729-15 15-15 8.284 0 15-6.716 15-15v-30.991h64c8.284 0 15 6.716 15 15v92.731C11.752-25.751 15-20.758 15-15 15-6.716 8.284 0 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(497.008 135.998)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0v-203.525h30V-.016a75.135 75.135 0 0 0-15-1.508C9.923-1.524 4.902-1.002 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(451 369.523)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path
                                                    d="M0 0c11.517 0 22.033 4.354 30 11.495C37.968 4.354 48.484 0 60 0c11.517 0 22.033 4.354 30 11.495C97.968 4.354 108.484 0 120 0c11.517 0 22.033 4.354 30 11.495C157.968 4.354 168.484 0 180 0c11.517 0 22.033 4.354 30 11.495C217.968 4.354 228.483 0 240 0s22.033 4.354 30.001 11.495C277.969 4.354 288.484 0 300.001 0S322.033 4.353 330 11.494C337.968 4.353 348.483 0 360 0s22.032 4.354 30 11.495C397.968 4.354 408.483 0 420 0c24.813 0 45 20.187 45 44.999V99c0 8.284-6.716 15-15 15H-30c-8.284 0-15-6.716-15-15V44.999C-45 20.187-24.813 0 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(46 397.999)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                                <path d="M0 0v-203.51h30V.015A74.95 74.95 0 0 0 0 0"
                                                    style="fill-opacity:1;fill-rule:nonzero;stroke:none"
                                                    transform="translate(31 369.508)" fill="#148a9d"
                                                    data-original="#148a9d" class=""></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $totalVendor }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Total Vendor</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        <div class="col-md-12 bg-white rounded shadow">
                            <div class="card">
                                <div class="card-header" style="text-align: center; font-size: 20px; font-weight: bold;">
                                    Peta Vendor Bahan Baku
                                </div>
                                <div class="legend" style="margin-bottom: 5px; display: flex; align-items: center;">
                                    <h5 style="margin-left: 20px; font-weight: bold; margin-top:10px; margin-right:10px;">
                                        Komoditi : </h5>
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
                    </section>
                    <section class="col-lg-5 connectedSortable">

                        <!-- BAR CHART -->
                        <div class="container px-7 mx-auto">
                            <div class="p-6 m-20 bg-white rounded shadow">
                                <div id="chart"></div>
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
                </div>
            </div>
        </div>
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

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-3.160237881740241, 111.97376353377497], 5);

            const tiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
                maxZoom: 50,
                id: 'mapbox/streets-v11',
                accessToken: 'your.mapbox.access.token'
            }).addTo(map);

            // Data lokasi dari backend (laravel) locations dalam format JSON
            const locationsVen = @json($locationsVen);
            const iconsLegend = @json($iconsLegend);
            const zoomLevels = {
                1: {
                    lat: -6.8638896542228105,
                    lon: 111.91690249608592,
                    zoom: 10
                }, // GHOPO Tuban
                2: {
                    lat: -6.862084537748621,
                    lon: 111.45844893831284,
                    zoom: 10
                }, // SG Rembang
                3: {
                    lat: -6.81381003288771,
                    lon: 111.88562746834054,
                    zoom: 10
                }, // SBI Tuban
                4: {
                    lat: -4.799956009286747,
                    lon: 119.60816663988693,
                    zoom: 10
                }, // Semen Tonasa
                5: {
                    lat: -6.458664695262742,
                    lon: 106.93274391171009,
                    zoom: 10
                }, // SBI Narogong
                6: {
                    lat: -7.687812398575669,
                    lon: 109.0223195076442,
                    zoom: 10
                } // SBI Cilacap
            };

            // Mapping komoditi ke warna
            const iconMapping = {
                'Purified Gypsum': 'images/PurifiedGypsum.png',
                'Copper Slag': 'images/CopperSlag.png',
                'Fly Ash': 'images/FlyAsh.png',
                'PT. Semen Indonesia (Persero) Tbk': 'images/ghopotuban.png', // Icon for Tuban factory
                'PT. Semen Gresik Rembang': 'images/sgrembang.png',
                'Pabrik SBI Tuban ': 'images/solusibangunindonesia.png',
                'Pabrik Semen Tonasa ': 'images/semenTonasa.png',
                'Pabrik SBI Narogong ': 'images/solusibangunindonesia.png',
                'Pabrik SBI Cilacap ': 'images/solusibangunindonesia.png'
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
            @if ($OpcoId)
                const selectedOpco = zoomLevels[{{ $OpcoId }}];
                if (selectedOpco) {
                    map.setView([selectedOpco.lat, selectedOpco.lon], selectedOpco.zoom);
                }
            @endif
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
                // Admin for SBI Tuban (opco_id = 3), show only the SBI Tuban icon
                const sbitubicon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.81381003288771, 111.88562746834054], {
                    icon: sbitubicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Tuban, Tbk</h5>
        </div>
    `).addTo(map);
                // Admin for Semen Tonasa (opco_id = 4), show only the SBI Tuban icon
                const sticon = L.icon({
                    iconUrl: 'images/semenTonasa.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-4.799956009286747, 119.60816663988693], {
                    icon: sticon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Tonasa (Persero). Tbk</h5>
        </div>
    `).addTo(map);
                // Admin for SBI Narogong (opco_id = 5), show only the SBI Tuban icon
                const sbinaricon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.458664695262742, 106.93274391171009], {
                    icon: sbinaricon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Narogong. Tbk</h5>
        </div>
    `).addTo(map);
                // Admin for SBI Cilacap (opco_id = 6), show only the SBI Tuban icon
                const sbicilicon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-7.687811734050903, 109.02232084874895], {
                    icon: sbicilicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Cilacap. Tbk</h5>
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
            @elseif ($OpcoId == 3)
                // Admin for SBI Tuban (opco_id = 3), show only the SBI Tuban icon
                const sbitubicon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.81381003288771, 111.88562746834054], {
                    icon: sbitubicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Tuban, Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 4)
                // Admin for Semen Tonasa (opco_id = 4), show only the SBI Tuban icon
                const sticon = L.icon({
                    iconUrl: 'images/semenTonasa.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-4.799956009286747, 119.60816663988693], {
                    icon: sticon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Tonasa(Persero). Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 5)
                // Admin for SBI Narogong (opco_id = 5), show only the SBI Tuban icon
                const sbinaricon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-6.458664695262742, 106.93274391171009], {
                    icon: sbinaricon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Narogong. Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 6)
                // Admin for SBI Cilacap (opco_id = 6), show only the SBI Tuban icon
                const sbicilicon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-7.687811734050903, 109.02232084874895], {
                    icon: sbicilicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Cilacap. Tbk</h5>
        </div>
    `).addTo(map);
            @endif
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>
@endpush
