@extends('layouts.layouts')
@section('halaman')
    <li class="breadcrumb-item text-white opacity-75">Data Ujian</li>
@endsection
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" data-kt-program-studi-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Ujian" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        <!--begin::Filter-->

                        <!--end::Export-->
                        <!--begin::Add customer-->
                        <a href="{{ route('validasi.laporan') }}" class="btn btn-primary btn-sm" target="_blank">
                            Cetak Laporan
                        </a>
                        <!--end::Add customer-->
                    </div>
                    <!--end::Toolbar-->
                    <!--begin::Group actions-->
                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-customer-table-toolbar="selected">
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table id="kt_datatable_fixed_header" class="table table-striped table-row-bordered gy-5 gs-7">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>No</th>
                            <th>Mata Kuliah</th>
                            <th>Prodi</th>
                            <th>Pelaksanaan</th>
                            <th>Status</th>
                            <th>Template Soal</th>
                            <th>Batas Upload Soal</th>
                            <th>Pengupload</th>
                            <th>Soal Ujian</th>
                            <th>Validasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ujians as $index => $ujian)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ujian->mataKuliah->kode_mata_kuliah }} - {{ $ujian->mataKuliah->nama_mata_kuliah }}</td>
                                <td>{{ $ujian->mataKuliah->prodi->nama_prodi }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->format('d-m-Y') }}<br>
                                    {{ \Carbon\Carbon::parse($ujian->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($ujian->waktu_selesai)->format('H:i') }}
                                </td>
                                <td>
                                    <!-- Logic for Status -->
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $waktuMulai = \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->setTimeFromTimeString($ujian->waktu_mulai);
                                        $waktuSelesai = \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->setTimeFromTimeString($ujian->waktu_selesai);
                                    @endphp

                                    @if ($now->greaterThan($waktuSelesai))
                                        <span class="badge bg-danger">Berakhir</span>
                                    @elseif ($now->between($waktuMulai, $waktuSelesai))
                                        <span class="badge bg-success">Sedang Berlangsung</span>
                                    @else
                                        <span class="badge bg-warning">Belum Berlangsung</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ujian->kopSoalUjian)
                                        <a href="{{ Storage::url($ujian->kopSoalUjian->path_file) }}" target="_blank"><i class="fa fa-check-circle"></i>&nbsp; Download {{ $ujian->kopSoalUjian->nama_file }}</a>
                                    @elseif($now->lessThan($waktuMulai))
                                        <p class="text-danger">Belum diupload oleh admin</p>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Upload Ditutup</button>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->format('d-m-Y H:i') }}</td>
                                <td>{{ $ujian->pengupload->nama_lengkap ?? 'None' }}</td>
                                <td>
                                    @if($ujian->soalUjian)
                                    <a href="{{ Storage::url($ujian->kopSoalUjian->path_file) }}" target="_blank">
    <i class="fa fa-check-circle"></i>&nbsp; Download {{ $ujian->kopSoalUjian->path_file }}
                                    @else
                                        @if ($now->lessThan($waktuMulai))
                                            <p class="text-warning">Belum Diupload</p>
                                        @else
                                            <p class="text-danger">Tidak Diupload</p>
                                        @endif
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if ($ujian->soalUjian)
                                            @if ($ujian->soalUjian->validasi && $ujian->soalUjian->validasi->status == "validated")
                                                <div class="d-flex align-items-center text-success">
                                                    <i class="fa fa-check-circle"></i>&nbsp;<span>Validated</span>
                                                </div>
                                            @elseif($ujian->soalUjian->validasi && $ujian->soalUjian->validasi->status == "rejected")
                                                <div class="d-flex align-items-center text-danger">
                                                    <i class="fa fa-close"></i>&nbsp;<span>Rejected</span>
                                                </div>
                                            @elseif(!$ujian->soalUjian->validasi)
                                            <button type="button" class="btn btn-sm btn-primary" onclick="validasi({{ $ujian->id }})">Validasi</button>

                                                <!-- <button type="button" class="btn btn-sm btn-primary" onclick="validasi"({{ $ujian->soalUjian->id }})">Validasi</button> -->
                                            @endif
                                        @else
                                        <button type="button" class="btn btn-sm btn-secondary" disabled>Validasi</button>

                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
        <!--begin::Modals-->
        <!--begin::Modal - Customers - Add-->
        @include('validasi._modal_validasi')
        <!--end::Modal - Customers - Add-->
        <!--end::Modals-->
    </div>
@endsection

@push('scripts')
    <script>
        function validasi(soalUjianId) {
            // Set nilai soalUjianId di input hidden form
            $('#soal_ujian_id').val(soalUjianId);

            // Tampilkan modal validasi
            $('#validasiModal').modal('show');
        }

        function submitValidasi() {
            var soalUjianId = $('#soal_ujian_id').val();  // Ambil ID soal ujian dari form
            var form = document.getElementById('formValidasi');

            if (form) {
                var formData = new FormData(form);

                $.ajax({
                    url: '{{ route("validasi.post", ":soal") }}'.replace(':soal', soalUjianId),  // Ganti ':soal' dengan ID soal

                    // url: '{{ route("validasi.post", ":soal") }}'.replace(':soal', soalUjianId),  // Ganti ':soal' dengan ID soal
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: "Sukses!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            $('#validasiModal').modal('hide');
                            location.reload();  // Refresh halaman setelah validasi
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {  // Status 422 berarti ada error validasi
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';

                            // Looping melalui error dan tampilkan di SweetAlert
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';  // Gabungkan pesan error
                            });

                            Swal.fire({
                                title: "Error Validasi!",
                                html: errorMessage,  // Gunakan HTML untuk menampilkan error line by line
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        } else {
                            // Jika bukan error validasi, tampilkan pesan kesalahan umum
                            var errorDetail = xhr.responseJSON.error || "Terjadi kesalahan yang tidak diketahui.";

                            Swal.fire({
                                title: "Error!",
                                text: xhr.responseJSON.message + ": " + errorDetail,  // Tampilkan pesan error detail dari server
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    }
                });
            }
        }

    </script>
@endpush
