@extends('layout.template')

@section('css')
    <style>
        .card.card-outline.card-primary {
            margin: auto;
            background-color: rgb(245, 245, 245);
            border-top-color: #800000;
            border-top: 4px solid #800000;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        th {
            text-align: center;
            background-color: #800000;
            color: white;
        }

        .btn-gradient {
            background: linear-gradient(to right, #800000, #c81b1b);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }

        .btn-gradientu {
            background: linear-gradient(to right, #484848, #787878);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }

        .btn-gradientuw {
            background: linear-gradient(to right, #000000, #333333);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }

        .btn-gradient-restore {
            background: linear-gradient(to right, #008000, #00a000);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
            border-radius: 8px;
            transition: opacity 0.3s ease;
        }

        .alert-note {
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .bg-light-primary {
            background-color: rgba(128, 0, 0, 0.08);
        }

        .border-left-primary {
            border-left: 4px solid #800000;
        }

        .text-primary {
            color: #800000;
        }

        .bg-light-danger {
            background-color: rgba(255, 0, 0, 0.08);
        }

        .border-left-danger {
            border-left: 4px solid #ff0000;
        }

        .text-danger {
            color: #ff0000;
        }

        .catatan-penting {
            --warna-utama: #800000;
            --warna-teks: #000000;
            --font-size-judul: 1.25rem;
            --font-size-subjudul: 1.1rem;
            --font-size-isi: 1rem;
        }

        .catatan-penting .card-header h4 {
            color: var(--warna-utama);
            font-size: var(--font-size-judul);
            font-weight: 600;
        }

        .catatan-penting .card-header i {
            color: var(--warna-utama);
        }

        .catatan-penting .alert-note {
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background-color: rgba(128, 0, 0, 0.08);
            border-left: 4px solid var(--warna-utama);
        }

        .catatan-penting .alert-heading {
            color: var(--warna-utama);
            font-size: var(--font-size-subjudul);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .catatan-penting .alert-note p {
            color: var(--warna-teks);
            font-size: var(--font-size-isi);
            margin-bottom: 0;
        }

        .catatan-penting .fa-bullhorn {
            color: var(--warna-utama);
            font-size: 1.5rem;
        }
    </style>
@endsection

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-body">
            <h4 class="text-center">Riwayat Penilaian</h4>
            <div class="separator"></div>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <table class="table table-bordered table-striped" id="table_history">
                <thead>
                    <tr>
                        <th>No</th>
                        {{-- <th>Nama OPCO</th> --}}
                        <th>Lokasi/IUP</th>
                        <th>Total Skor</th>
                        <th>Tanggal Simpan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            {{-- <td>{{ $item['nama_opco'] ?? 'N/A' }}</td> --}}
                            <td>{{ $item['lokasi_iup'] }}</td>
                            <td>{{ $item['total_skor'] }}</td>
                            <td>{{ $item['tanggal_simpan'] }}</td>
                            <td>
                                <button class="btn-gradientu" data-index="{{ $index }}"
                                    data-lokasi="{{ $item['lokasi_iup'] }}">
                                    Detail
                                </button>
                                <button class="btn-gradientuw" data-index="{{ $index }}"
                                    data-lokasi="{{ $item['lokasi_iup'] }}">
                                    Cetak PDF
                                </button>
                                <button class="btn-gradient" data-index="{{ $index }}"
                                    data-lokasi="{{ $item['lokasi_iup'] }}">
                                    Hapus
                                </button>
                                <button class="btn-gradient-restore" data-index="{{ $index }}"
                                    data-lokasi="{{ $item['lokasi_iup'] }}">
                                    Restore
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-primary card-outline mt-4 catatan-penting">
        <div class="card-header bg-white">
            <h4 class="m-0"><i class="fas fa-info-circle mr-2"></i>Catatan Penting</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-note">
                <div class="d-flex align-items-start">
                    <div class="mr-3">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <div>
                        <h5 class="alert-heading">Perhatian</h5>
                        <p>
                            Hasil penilaian penerbitan prioritas perluasan lahan bahan baku ini hanya sebagai rekomendasi.
                            Keputusan utama penerbitan perluasan lahan tetap berada di tangan stakeholder.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('.btn-gradientu').click(function() {
            const index = $(this).data('index');
            window.location.href = "{{ route('history.detail', '') }}/" + index;
        });
        // Ubah script untuk tombol cetak PDF
        $('.btn-gradientuw').click(function() {
            const index = $(this).data('index');
            window.location.href = "{{ route('history.cetak-pdf', '') }}/" + index;
        });
        $(document).ready(function() {
            // SweetAlert for delete confirmation
            $('.btn-gradient').click(function() {
                const index = $(this).data('index');
                const lokasi = $(this).data('lokasi');

                Swal.fire({
                    title: 'Hapus Riwayat?',
                    html: `Anda yakin ingin menghapus riwayat untuk <b>${lokasi}</b>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('history.hapus', '') }}/" + index,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'DELETE'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: 'Terhapus!',
                                    text: 'Riwayat berhasil dihapus',
                                    icon: 'success',
                                    confirmButtonColor: '#800000'
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Terjadi kesalahan saat menghapus data',
                                    icon: 'error',
                                    confirmButtonColor: '#800000'
                                });
                            }
                        });
                    }
                });
            });

            // Show success/error message from session
            @if (session('success'))
                Swal.fire({
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: '#800000'
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: '#800000'
                });
            @endif
        });
    </script>
@endpush
