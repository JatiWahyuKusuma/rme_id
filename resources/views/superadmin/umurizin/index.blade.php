@extends('layout.template')

@section('css')
    <style>
        .card.card-outline.card-primary {
            margin: 20px;
            padding: 15px;
            background-color: rgb(245, 245, 245);
            border-top-color: #800000;
            border-top: 4px solid #800000;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);

        }

        .btn-gradient {
            background: linear-gradient(to right, #800000, #c81b1b);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }


        .teal-lime-btn {
            background: linear-gradient(to right, #949494, #949494);
            color: white;
            font-size: 15px;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-align: center;
            width: 100%;
            transition: background 0.4s ease, transform 0.2s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Add these new styles for Select2 */
        .select2-container--default .select2-selection--single {
            height: 38px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding-top: 4px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            padding: 6px;
            width: 100%;
        }

        .select2-results__option {
            padding: 8px 12px;
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="{{ url('umurizin') }}" method="GET" class="row mb-4 gx-5 align-items-end" id="filterForm">
                @csrf
                <input type="hidden" id="current_lokasi_iup" value="{{ request('lokasi_iup') }}">
                <div class="col-md-4">
                    <label for="opco_id" class="fw-bold">Opco</label>
                    <select class="form-control " name="opco_id" id="opco_id">
                        <option value="">Pilih Opco</option>
                        @foreach ($opco as $item)
                            <option value="{{ $item->opco_id }}"
                                {{ request('opco_id') == $item->opco_id ? 'selected' : '' }}>
                                {{ $item->nama_opco }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="lokasi_iup" class="fw-bold">Lokasi IUP</label>
                    <select class="form-control select2 select2-hidden-accessible"" name="lokasi_iup" id="lokasi_iup">
                        <option value="">Pilih Lokasi IUP</option>
                        @foreach ($lokasi_iup_all as $lokasi)
                            <option value="{{ $lokasi }}" {{ request('lokasi_iup') == $lokasi ? 'selected' : '' }}>
                                {{ $lokasi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="fw-bold d-block invisible">Tombol</label>
                    <div class="d-flex justify-content-between gap-1">
                        <button type="submit" class="btn-gradient btn-lg w-25">Submit</button>
                    </div>
                </div>
            </form>
        </div>

        @if (request()->filled('opco_id') || request()->filled('lokasi_iup'))
            <table class="table table-bordered table-striped table-hover table-sm mt-4">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Opco</th>
                        <th>Lokasi IUP</th>
                        <th>Umur Masa Berlaku Izin</th>
                        <th>Umur Habis</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cadanganbb as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_opco }}</td>
                            <td>{{ $item->lokasi_iup }}</td>
                            <td>{{ $item->umur_masa_berlaku_izin }}</td>
                            <td>{{ $item->tahun_habis }}</td>
                            <td
                                style="
                            background-color: {{ $item->status === 'Critical'
                                ? '#dc0b0b'
                                : ($item->status === 'Prioritas 1'
                                    ? '#e85d00'
                                    : ($item->status === 'Prioritas 2'
                                        ? '#ffff00'
                                        : ($item->status === 'Aman'
                                            ? '#08ff00'
                                            : 'transparent'))) }};
                            color: {{ in_array($item->status, ['Critical', 'Prioritas 1']) ? 'white' : 'black' }};
                            font-weight: bold">
                                {{ $item->status }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-md-4">
                <label class="fw-bold d-block invisible">Tombol</label>
                <div class="d-flex justify-content-between gap-1">
                    <a href="{{ url('umurizin') }}" class="teal-lime-btn btn-lg w-25">Reset</a>
                </div>
            </div>
        @endif

        <div class="card card-primary card-outline mt-4">
            <h3 class="m-0">Keterangan</h3>
            <div class="d-flex flex-column align-items-start pt-3">
                <div class="d-flex mb-2">
                    <button type="button" class="btn btn-sm"
                        style="background-color: #dc0b0b; color: white; width: 150px;">Critical</button>
                    <span class="ms-4">
                        : Masa berlaku izin kurang dari 1 tahun
                    </span>
                </div>
                <div class="d-flex mb-2">
                    <button type="button" class="btn btn-sm"
                        style="background-color: #e85d00; color: white; width: 150px;">Prioritas 1</button>
                    <span class="ms-3">
                        : Masa berlaku izin 1 hingga 2 tahun

                    </span>
                </div>
                <div class="d-flex mb-2">
                    <button type="button" class="btn btn-sm"
                        style="background-color: #08ff00; color: black; width: 150px;">Aman</button>
                    <span class="ms-3">
                        : Masa berlaku izin lebih dari 2 tahun
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for Opco dropdown
            $('#opco_id').select2({
                placeholder: "Pilih Opco",
                allowClear: true,
                width: '100%'
            });

            // Initialize Select2 for Lokasi IUP dropdown with enhanced search
            $('#lokasi_iup').select2({
                placeholder: "Pilih atau ketik Lokasi IUP",
                allowClear: true,
                width: '100%',
                dropdownAutoWidth: true,
                minimumInputLength: 0, // Allow searching without minimum characters
                language: {
                    inputTooShort: function() {
                        return 'Ketik untuk mencari Lokasi IUP';
                    },
                    noResults: function() {
                        return 'Lokasi tidak ditemukan';
                    },
                    searching: function() {
                        return 'Mencari...';
                    }
                }
            });

            // Focus on search field when dropdown opens
            $('#lokasi_iup').on('select2:open', function() {
                document.querySelector('.select2-search__field').focus();
            });

            // Dynamic lokasi_iup filtering based on opco selection
            $('#opco_id').change(function() {
                var opcoId = $(this).val();
                var currentLokasiIup = $('#current_lokasi_iup').val();

                // Clear and reset lokasi_iup dropdown
                var $lokasiDropdown = $('#lokasi_iup');
                $lokasiDropdown.empty().append('<option value="">Pilih Lokasi IUP</option>');

                if (opcoId) {
                    $.ajax({
                        url: "{{ url('umurcadangan') }}",
                        type: "GET",
                        data: {
                            opco_id: opcoId,
                            ajax: true
                        },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $lokasiDropdown.append('<option value="' + value +
                                    '">' + value + '</option>');
                            });

                            // Re-select current value if it exists in the new options
                            if (currentLokasiIup && data.includes(currentLokasiIup)) {
                                $lokasiDropdown.val(currentLokasiIup).trigger('change');
                            }

                            // Reinitialize Select2 with enhanced search
                            $lokasiDropdown.select2({
                                placeholder: "Pilih atau ketik Lokasi IUP",
                                allowClear: true,
                                width: '100%',
                                dropdownAutoWidth: true,
                                minimumInputLength: 0,
                                language: {
                                    inputTooShort: function() {
                                        return 'Ketik untuk mencari Lokasi IUP';
                                    },
                                    noResults: function() {
                                        return 'Lokasi tidak ditemukan';
                                    },
                                    searching: function() {
                                        return 'Mencari...';
                                    }
                                }
                            });
                        }
                    });
                } else {
                    // Load all options if no opco selected
                    $.ajax({
                        url: "{{ url('umurcadangan') }}",
                        type: "GET",
                        data: {
                            ajax: true
                        },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $lokasiDropdown.append('<option value="' + value +
                                    '">' + value + '</option>');
                            });

                            if (currentLokasiIup && data.includes(currentLokasiIup)) {
                                $lokasiDropdown.val(currentLokasiIup).trigger('change');
                            }

                            $lokasiDropdown.select2({
                                placeholder: "Pilih atau ketik Lokasi IUP",
                                allowClear: true,
                                width: '100%',
                                dropdownAutoWidth: true,
                                minimumInputLength: 0,
                                language: {
                                    inputTooShort: function() {
                                        return 'Ketik untuk mencari Lokasi IUP';
                                    },
                                    noResults: function() {
                                        return 'Lokasi tidak ditemukan';
                                    },
                                    searching: function() {
                                        return 'Mencari...';
                                    }
                                }
                            });
                        }
                    });
                }
            });

            // Trigger change on page load if opco_id is selected
            @if (request()->filled('opco_id'))
                $('#opco_id').trigger('change');
            @endif
        });
    </script>
@endsection
