@extends('layoutAdmin.template')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #map {
            height: 655px;
        }

        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color: rgb(46, 46, 46);
        }

        .row {
            margin: auto;
        }

        .h1 {
            text-shadow: 2px 2px 5px red;
        }

        .form-group.row {
            margin-top: 20px;
        }

        #reset-filter {
            border-color: #000000;
            background-color: #ffffff;
        }

        #reset-filter:hover {
            background-color: #000000;
        }

        .btn-gradientu {
            background: linear-gradient(to right, #a0a0a0, #535353);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
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
                data: @json($sdCadanganTons) // Ensure this data aligns with the colors
            }],
            chart: {
                type: 'bar',
                height: 380
            },
            title: {
                text: 'Grafik Cadangan Bahan Baku',
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
        <div class="card card-outline card-primary">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-1 control-label col-form-label">Filter: </label>
                            <div class="col-3">
                                <select class="form-control" name="opco_id" id="opco_id">
                                    <option value="">-- Semua Opco --</option>
                                    @foreach ($opco as $opcoItem)
                                        <option value="{{ $opcoItem->opco_id }}"
                                            {{ request('opco_id') == $opcoItem->opco_id ? 'selected' : '' }}>
                                            {{ $opcoItem->nama_opco }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Opco</small>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <select class="form-control" name="lokasi_iup" id="lokasi_iup">
                                        <option value="">-- Semua Lokasi IUP --</option>
                                        @foreach ($lokasiOptions as $lokasi)
                                            <option value="{{ $lokasi }}"
                                                {{ request('lokasi_iup') == $lokasi ? 'selected' : '' }}>
                                                {{ $lokasi }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append ml-2">
                                        <button class="btn-gradientu" type="button" id="reset-filter"
                                            style="padding: 6px 15px;">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                                <small class="form-text text-muted">Lokasi IUP</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-4" style="margin-top: 10px;">
                        <div class="small-box bg-success" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" x="0" y="0"
                                        viewBox="0 0 512 511" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                        class="">
                                        <g>
                                            <path
                                                d="M300.844 476.125c-2.559 2.121-5.121 4.063-7.68 6.004-10.86 8.121-19.508 14.566-19.508 30.367h44.137a40.703 40.703 0 0 0-7.328-16.95 97.104 97.104 0 0 1-9.621-19.421zM282.57 468.004a44.01 44.01 0 0 0 18.008-20.125l.531-1.324a66.36 66.36 0 0 1 19.332-26.57 68.206 68.206 0 0 0 24.012-41.669c.102-.402.16-.816.176-1.234a64.642 64.642 0 0 0-23.305-60.559 8.875 8.875 0 0 1-2.117-2.382l-22.777-3.797a8.94 8.94 0 0 0-8.387 3.18l-98.781 123.585a9.016 9.016 0 0 1-9.707 2.825l-68.68-22.864a8.541 8.541 0 0 0-8.738 1.856L0 512.496h256c0-24.629 14.742-35.664 26.57-44.492zM335.45 512.496h167.636c-1.414-8.473-12.36-60.203-69.477-53.055a4.189 4.189 0 0 1-1.058.09 75.726 75.726 0 0 1-59.672-14.476 74.827 74.827 0 0 1-22.16-33.547 99.205 99.205 0 0 1-18.008 21.187 49.306 49.306 0 0 0-15.36 20.832c-4.058 12.184 1.942 22.246 8.297 33.016a53.31 53.31 0 0 1 9.801 25.953zm0 0"
                                                fill="#228e3b" opacity="1" data-original="#228e3b" class="">
                                            </path>
                                            <path
                                                d="m368.64 293.926-21.187 21.187a7.13 7.13 0 0 1-1.851 1.324 78.56 78.56 0 0 1 16.593 62.938c.973 13.95 5.207 38.227 21.895 52.086a59.57 59.57 0 0 0 46.61 10.59h.085c12.625-3.266 19.774-12.18 27.985-22.598 11.476-14.3 24.453-30.543 53.23-30.543V150.566l-24.188 56.407a8.831 8.831 0 0 1-8.12 5.386h-30.544a8.822 8.822 0 0 0-8.738 7.766l-7.062 56.145a8.832 8.832 0 0 1-7.504 7.68l-52.172 7.417a8.914 8.914 0 0 0-5.031 2.559zM512 483.719v-77.153c-20.305 0-28.691 10.594-39.46 23.922a137.784 137.784 0 0 1-10.68 12.446 69.35 69.35 0 0 1 44.226 30.457A83.397 83.397 0 0 1 512 483.719zM217.875 137.324s97.703 93.988 125.52 164.086c0 0 14.847-68.676-79.016-178.644l6.75-6.125c6.559-6.676 6.77-17.309.48-24.239-6.289-6.93-16.894-7.746-24.171-1.863l-6.754 6.125C140.359-7.449 70.62.648 70.62.648c67.027 34.516 147.254 136.676 147.254 136.676zM229.516 300.633s35.312-26.48 52.968-26.48c0 0-26.484-17.657-44.14-17.657-17.653 0-8.828 44.137-8.828 44.137zM370.758 247.668s35.312 8.828 35.312-8.828c0-17.653-26.484-35.309-26.484-35.309 8.828 17.656-8.828 44.137-8.828 44.137zM344.277 159.395c4.875 0 8.825-3.954 8.825-8.829V132.91c0-4.875-3.95-8.828-8.825-8.828s-8.828 3.953-8.828 8.828v17.656a8.829 8.829 0 0 0 8.828 8.829zM366.813 176.164a8.81 8.81 0 0 0 6.742.48 8.83 8.83 0 0 0 5.105-4.433l8.828-17.656c2.18-4.364.407-9.668-3.957-11.848-4.363-2.176-9.668-.406-11.847 3.957l-8.825 17.656a8.81 8.81 0 0 0-.48 6.743 8.811 8.811 0 0 0 4.433 5.101zm0 0"
                                                fill="#228e3b" opacity="1" data-original="#228e3b" class="">
                                            </path>
                                            <path
                                                d="M55.438 312.375 216.98 161.422c-6.882-7.059-11.21-11.211-11.386-11.387l-.883-.883-.707-.968c-.176-.18-4.059-5.121-10.68-12.977L31.691 286.247c-4.757 4.218-6.875 10.667-5.55 16.886s5.89 11.246 11.957 13.156a17.65 17.65 0 0 0 17.34-3.914zm0 0"
                                                fill="#228e3b" opacity="1" data-original="#228e3b" class="">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $sdCadanganTon }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Total
                                        SD/Cadangan
                                        (ton)</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-4" style="margin-top: 10px;">
                        <div class="small-box bg-warning" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" x="0" y="0"
                                        viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"
                                        class="">
                                        <g>
                                            <g data-name="Layer 20">
                                                <path
                                                    d="M18.5 7a6.465 6.465 0 0 1 .74-3H9.36a2.046 2.046 0 0 0-1.28.46L2.72 8.93A1.985 1.985 0 0 0 2 10.47V28a2.006 2.006 0 0 0 2 2h19a2.006 2.006 0 0 0 2-2V13.5A6.513 6.513 0 0 1 18.5 7Zm-11 3h8a1 1 0 0 1 0 2h-8a1 1 0 0 1 0-2ZM18 26h-2.79a1.499 1.499 0 0 1-1.06-.44l-.99-.99-.91 1.36a1.501 1.501 0 0 1-2.5 0l-.91-1.36-1.13 1.14a1.004 1.004 0 0 1-1.42-1.42l1.57-1.57a1.543 1.543 0 0 1 1.21-.43 1.525 1.525 0 0 1 1.1.66L11 24.2l.83-1.25a1.525 1.525 0 0 1 1.1-.66 1.543 1.543 0 0 1 1.21.43L15.41 24H18a1 1 0 0 1 0 2Zm1.5-6h-12a1 1 0 0 1 0-2h12a1 1 0 0 1 0 2Zm0-4h-12a1 1 0 0 1 0-2h12a1 1 0 0 1 0 2Z"
                                                    fill="#d9a406" opacity="1" data-original="#d9a406" class="">
                                                </path>
                                                <path
                                                    d="M25 2a5 5 0 1 0 5 5 5.006 5.006 0 0 0-5-5Zm2.8 3.6-3 4a1 1 0 0 1-.73.398A1.163 1.163 0 0 1 24 10a.999.999 0 0 1-.707-.293l-1.5-1.5a1 1 0 0 1 1.414-1.414l.685.685L26.2 4.4a1 1 0 0 1 1.6 1.2Z"
                                                    fill="#d9a406" opacity="1" data-original="#d9a406" class="">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $totalberlakuIUP }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Total IUP OP</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-4" style="margin-top: 10px;">
                        <div class="small-box bg-danger" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" x="0"
                                        y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M389.513 87.422c0-12.012-4.688-23.32-13.184-31.816l-42.422-42.422C325.529 4.805 313.636 0 301.8 0h-2.578v90h90.292l-.001-2.578z"
                                                fill="#a93540" opacity="1" data-original="#a93540" class="">
                                            </path>
                                            <path
                                                d="M273.937 309.537c2.871-8.716 7.881-16.831 14.414-23.408l101.562-101.153V120h-105.4c-8.291 0-14.513-6.709-14.513-15V0H45C20.186 0 0 20.186 0 45v422c0 24.814 20.186 45 45 45h299.513c24.814 0 45.4-20.186 45.4-45V355.049l-16.484 16.084c-6.679 6.621-14.501 11.44-23.32 14.385l-47.695 15.923-7.266.396c-12.012 0-23.379-5.845-30.439-15.63-7.002-9.741-8.906-22.368-5.098-33.779l14.326-42.891zM75 270h149.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75c-8.291 0-15-6.709-15-15s6.709-15 15-15zm-15-45c0-8.291 6.709-15 15-15h149.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75c-8.291 0-15-6.709-15-15zm0 120c0-8.291 6.709-15 15-15h149.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75c-8.291 0-15-6.709-15-15zm224.513 75c8.291 0 15 6.709 15 15s-6.708 15-15 15h-90c-8.291 0-15-6.709-15-15s6.709-15 15-15h90zM75 180c-8.291 0-15-6.709-15-15s6.709-15 15-15h209.513c8.291 0 15 6.709 15 15s-6.709 15-15 15H75z"
                                                fill="#a93540" opacity="1" data-original="#a93540" class="">
                                            </path>
                                            <path
                                                d="m301.111 322.808-13.05 39.151c-1.956 5.865 3.625 11.444 9.49 9.485l39.128-13.068-35.568-35.568zM417.609 199.307l-98.789 98.789 42.605 42.605c22.328-22.332 65.773-65.783 98.784-98.794l-42.6-42.6zM503.185 156.284c-5.273-5.303-13.037-8.335-21.27-8.335-8.233 0-15.996 3.032-21.299 8.35l-21.797 21.797 42.598 42.598 21.799-21.799c11.717-11.735 11.716-30.849-.031-42.611z"
                                                fill="#a93540" opacity="1" data-original="#a93540" class="">
                                            </path>
                                            <path
                                                d="m503.215 198.896.002-.002.086-.086a3.634 3.634 0 0 1-.088.088zM503.303 198.808l.133-.133-.133.133zM503.436 198.675c.097-.097.099-.099 0 0z"
                                                fill="#a93540" opacity="1" data-original="#a93540" class="">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $totalEksplorasi }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Total IUP
                                        Eksplorasi</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-3 col-4" style="margin-top: 10px;">
                        <div class="small-box bg-info" style="height: 130px;">
                            <div class="inner d-flex align-items-center" style="font-size: 30px;">
                                <div class="icon" style="font-size: 50px; margin-right: 20px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="100" height="100" x="0"
                                        y="0" viewBox="0 0 24 24" style="enable-background:new 0 0 512 512"
                                        xml:space="preserve" class="">
                                        <g>
                                            <path
                                                d="M17.839 11.785 16.429 10h.821a.75.75 0 0 0 .549-1.26l-3.25-3.5a.774.774 0 0 0-1.1 0l-3.25 3.5A.75.75 0 0 0 10.75 10h.827l-1.415 1.784A.75.75 0 0 0 10.75 13h2.5v1.25a.75.75 0 0 0 1.5 0V13h2.5a.751.751 0 0 0 .589-1.215z"
                                                fill="#148a9d" opacity="1" data-original="#148a9d" class="">
                                            </path>
                                            <path
                                                d="M23 17.021h-1v-14c0-1.654-1.346-3-3-3H3a.923.923 0 0 0-.491.16C1.064.612 0 1.938 0 3.521v1.5a1 1 0 0 0 1 1h4v14.458a3.504 3.504 0 0 0 3.498 3.5H21c1.654 0 3-1.346 3-3v-2.958a1 1 0 0 0-1-1zm-13 1v2.458c0 .827-.673 1.5-1.5 1.5s-1.5-.673-1.5-1.5V3.521c0-.539-.133-1.044-.351-1.5H19c.552 0 1 .449 1 1v14h-9a1 1 0 0 0-1 1z"
                                                fill="#148a9d" opacity="1" data-original="#148a9d" class="">
                                            </path>
                                        </g>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <h3 style="font-size: 40px;">{{ $totalberlakuPPKH }}</h3>
                                    <p style="font-size: 23px; margin-top: -10px; margin-bottom: 10px;">Total PPKH</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ./col -->
                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        <div class="col-md-12 bg-white rounded shadow">
                            <div class="card">
                                <div class="card-header" style="text-align: center; font-size: 20px; font-weight: bold;">
                                    Peta Cadangan Bahan Baku
                                </div>
                                <div class="legend" style="margin-bottom: 5px; display: flex; align-items: center;">
                                    <h6 style="margin-left: 10px; font-weight: bold; margin-top:5px; margin-right:10px;">
                                        Komoditi: </h6>
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
                            <div class="p-6 m-20 bg-white rounded shadow" style="max-height: 392px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead style="position: sticky; top: 0; background-color: white; z-index: 10;">
                                        <tr>
                                            <th class="text-center">Komoditi</th>
                                            <th class="text-center">Lokasi IUP</th>
                                            <th class="text-center">SD/Cadangan (ton)</th>
                                            <th class="text-center">Masa Berlaku IUP</th>
                                            <th class="text-center">Masa Berlaku PPKH</th>
                                            <th class="text-center">Luas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tableData as $data)
                                            <tr>
                                                <td>{{ $data->komoditi }}</td>
                                                <td>{{ $data->lokasi_iup }}</td>
                                                <td>{{ number_format($data->sd_cadangan_ton, 0, '.', '.') }}</td>
                                                <!-- Tanda warna kuning untuk Masa Berlaku IUP -->
                                                <td class="{{ $data->warning_iup ? 'bg-warning' : '' }}">
                                                    {{ $data->masa_berlaku_iup }}
                                                </td>
                                                <!-- Tanda warna kuning untuk Masa Berlaku PPKH -->
                                                <td class="{{ $data->warning_ppkh ? 'bg-warning' : '' }}">
                                                    {{ $data->masa_berlaku_ppkh }}
                                                </td>
                                                <td>{{ $data->luas_ha }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <style>
                            .bg-warning {
                                background-color: yellow;
                                /* Sesuaikan warna jika diperlukan */
                            }
                        </style>

                    </section>
                    <!-- right col -->
                </div>
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

    </script>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Reset filter button functionality
            document.getElementById('reset-filter').addEventListener('click', function() {
                // Clear both select elements
                document.getElementById('opco_id').value = '';
                document.getElementById('lokasi_iup').value = '';

                // Submit the form (or redirect) with empty filters
                window.location.href = window.location.pathname; // This will remove all query params
            });

            // Existing filter change handlers
            document.getElementById('opco_id').addEventListener('change', updateFilters);
            document.getElementById('lokasi_iup').addEventListener('change', updateFilters);

            function updateFilters() {
                const opcoId = document.getElementById('opco_id').value;
                const lokasiIup = document.getElementById('lokasi_iup').value;

                // Build URL with both filters
                let url = '?';
                if (opcoId) url += `opco_id=${opcoId}`;
                if (lokasiIup) {
                    if (opcoId) url += '&';
                    url += `lokasi_iup=${encodeURIComponent(lokasiIup)}`;
                }

                // Reload page with new filters
                window.location.href = url;
            }

        });
        document.addEventListener('DOMContentLoaded', function() {
            // Get current filter values from URL
            const urlParams = new URLSearchParams(window.location.search);
            const opcoId = urlParams.get('opco_id');
            const lokasiIup = urlParams.get('lokasi_iup');

            // Update both select elements
            if (opcoId) {
                document.getElementById('opco_id').value = opcoId;
            }
            if (lokasiIup) {
                document.getElementById('lokasi_iup').value = lokasiIup;
            }

            // Add event listeners to both filters
            document.getElementById('opco_id').addEventListener('change', updateFilters);
            document.getElementById('lokasi_iup').addEventListener('change', updateFilters);

            function updateFilters() {
                const opcoId = document.getElementById('opco_id').value;
                const lokasiIup = document.getElementById('lokasi_iup').value;

                // Build URL with both filters
                let url = '?';
                if (opcoId) url += `opco_id=${opcoId}`;
                if (lokasiIup) {
                    if (opcoId) url += '&';
                    url += `lokasi_iup=${encodeURIComponent(lokasiIup)}`;
                }

                // Reload page with new filters
                window.location.href = url;
            }

            // Rest of your existing JavaScript...
        });
        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-3.160237881740241, 111.97376353377497], 5);

            const tiles = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
                maxZoom: 50,
                id: 'mapbox/streets-v11',
                accessToken: 'your.mapbox.access.token'
            }).addTo(map);
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
                }, // SBI Cilacap
                7: {
                    lat: 5.451535421962084,
                    lon: 95.24642980917199,
                    zoom: 10
                }, // SBI Lhoknga
                8: {
                    lat: -0.9538889782848652,
                    lon: 100.46975045278182,
                    zoom: 10
                }, // Semen Padang
                9: {
                    lat: -4.115230975617444,
                    lon: 104.16263540642808,
                    zoom: 10
                } // Semen Baturaja
            };

            // Data lokasi dari backend (laravel) locations dalam format JSON
            const locations = @json($locations);
            const iconsLegend = @json($iconsLegend);

            // Mapping komoditi ke warna
            const iconMapping = {
                'Batugamping': 'images/Cadbatugamping.png',
                'Tanah Liat': 'images/Cadtanahliat.png',
                'Tras': 'images/CadTras.png',
                'Pasirkuarsa': 'images/Cadpasirkuarsa.png',
                'Agregat Basalt': 'images/CadAgregatBasalt.png',
                'Granit': 'images/CadGranit.png',
                'Pabrik Semen Indonesia Tuban': 'images/ghopotuban.png', // Icon for Tuban factory
                'Pabrik SG Rembang': 'images/sgrembang.png',
                'Pabrik SBI Tuban ': 'images/solusibangunindonesia.png',
                'Pabrik Semen Tonasa ': 'images/semenTonasa.png',
                'Pabrik SBI Narogong ': 'images/solusibangunindonesia.png',
                'Pabrik SBI Cilacap ': 'images/solusibangunindonesia.png',
                'Pabrik SBI Lhoknga ': 'images/solusibangunindonesia.png',
                'Pabrik Semen Padang ': 'images/SemenPadang.png',
                'Pabrik Semen Baturaja ': 'images/SemenBaturaja.png',
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
                            <td><strong> Status Penyelidikan </strong></td>
                            <td>${location.status_penyelidikan}</td>
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

                L.marker([-6.86213779763091, 111.458459666856], {
                    icon: rembangIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Gresik Rembang. Tbk</h5>
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
            <h5>PT. Solusi Bangun Indonesia Pabrik Tuban. Tbk</h5>
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
            <h5>PT. Semen Tonasa(Persero). Tbk</h5>
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
                // Admin for SBI Lhoknga (opco_id = 7), show only the SBI Tuban icon
                const sbilhokicon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([5.451535421962084, 95.24642980917199], {
                    icon: sbilhokicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Lhoknga. Tbk</h5>
        </div>
    `).addTo(map);
                // Admin for Semen Padang (opco_id = 8), show only the SBI Tuban icon
                const spicon = L.icon({
                    iconUrl: 'images/SemenPadang.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-0.9538889782848652, 100.46975045278182], {
                    icon: spicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Padang (Persero). Tbk</h5>
        </div>
    `).addTo(map);
                // Admin for Semen Baturaja (opco_id = 9 )
                const smbricon = L.icon({
                    iconUrl: 'images/SemenBaturaja.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-4.115230975617444, 104.16263540642808, ], {
                    icon: smbricon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Baturaja (Persero). Tbk</h5>
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

                L.marker([-6.86213779763091, 111.458459666856], {
                    icon: rembangIcon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Gresik Rembang. Tbk</h5>
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
            <h5>PT. Solusi Bangun Indonesia Pabrik Tuban. Tbk</h5>
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
            @elseif ($OpcoId == 7)
                // Admin for SBI Lhoknga (opco_id = 7), show only the SBI Tuban icon
                const sbilhokicon = L.icon({
                    iconUrl: 'images/solusibangunindonesia.png',
                    iconSize: [90, 30],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([5.451535421962084, 95.24642980917199], {
                    icon: sbilhokicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Solusi Bangun Indonesia Pabrik Lhoknga. Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 8)
                // Admin for Semen Padang (opco_id = 8), show only the SBI Tuban icon
                const spicon = L.icon({
                    iconUrl: 'images/SemenPadang.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-0.9538889782848652, 100.46975045278182], {
                    icon: spicon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Padang (Persero). Tbk</h5>
        </div>
    `).addTo(map);
            @elseif ($OpcoId == 9)
                // Admin for Semen Baturaja (opco_id = 9 )
                const smbricon = L.icon({
                    iconUrl: 'images/SemenBaturaja.png',
                    iconSize: [50, 50],
                    iconAnchor: [15, 30],
                    popupAnchor: [0, -30]
                });

                L.marker([-4.115230975617444, 104.16263540642808, ], {
                    icon: smbricon
                }).bindPopup(`
        <div style="font-family: Arial, sans-serif;">
            <h5>PT. Semen Baturaja (Persero). Tbk</h5>
        </div>
    `).addTo(map);
            @endif
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>
@endpush
