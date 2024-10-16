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
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                            Tambah Ujian
                        </button>
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
                            <th>Program Studi</th>
                            <th>Pelaksanaan Ujian</th>
                            <th>Ruangan</th>
                            <th>Batas Upload Soal</th>
                            <th>Status</th>
                            <th>Kop Soal Ujian</th>
                            <th>Aksi</th>
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
                                <td>{{ $ujian->ruangan }}</td>
                                <td>{{ \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->format('d-m-Y H:i') }}</td>
                                <td>
                                    <!-- Logic for Status -->
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $waktuMulai = \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->setTimeFromTimeString($ujian->waktu_mulai);
                                        $waktuSelesai = \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->setTimeFromTimeString($ujian->waktu_selesai);
                                    @endphp

                                    @if ($now->greaterThan($waktuSelesai))
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif ($now->between($waktuMulai, $waktuSelesai))
                                        <span class="badge bg-success">Sedang Berlangsung</span>
                                    @else
                                        <span class="badge bg-warning">Belum Berlangsung</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ujian->kopSoalUjian)
                                        <a href="{{ Storage::url($ujian->kopSoalUjian->path_file) }}" target="_blank"><i class=""></i>Download {{ $ujian->kopSoalUjian->nama_file }}</a>
                                        <button class="btn btn-sm btn-primary" onclick="updateKopSoal({{ $ujian->id }})">Edit</button>
                                    @elseif($now->lessThan($waktuMulai))
                                        <!-- Form Upload Kop Soal jika belum dimulai -->
                                        <button class="btn btn-sm btn-primary" onclick="uploadKopSoal({{ $ujian->id }})">Upload</button>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Upload Ditutup</button>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="editUjian({{ $ujian->id }})">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusUjian({{ $ujian->id }})">Hapus</button>
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
        @include('data_ujian._modal_tambah')
        @include('data_ujian._modal_edit')
        @include('data_ujian._modal_kop_soal')
        <!--end::Modal - Customers - Add-->
        <!--end::Modals-->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var dataTable = $("#kt_datatable_fixed_header").DataTable({
                "fixedHeader": {
                    "header": true,
                    "headerOffset": 5
                },
                "searching": true
            });

            // Menangani pencarian
            $('input[data-kt-program-studi-table-filter="search"]').on('keyup', function() {
                dataTable.search(this.value).draw();
            });

            $('#tambahModal').on('show.bs.modal', function () {
                $('#formUjian')[0].reset();
            });
        });

        function editUjian(id) {
            $.ajax({
                url: '{{ route("ujian.edit", ":id") }}'.replace(':id', id),  // Menggunakan route name 'mataKuliah.edit'
                type: 'GET',
                success: function(response) {
                    // Mengisi data ke dalam form edit
                    $('#ujian_id').val(response.id);
                    $('#edit_mata_kuliah_id').val(response.mata_kuliah_id);  // Set Mata Kuliah
                    $('#edit_tanggal_dilaksanakan').val(response.tanggal_dilaksanakan);  // Set Tanggal Ujian
                    // Pastikan format waktu sesuai (H:i)
                    $('#edit_waktu_mulai').val(response.waktu_mulai.slice(0, 5));  // Set Waktu Mulai (format HH:mm)
                    $('#edit_waktu_selesai').val(response.waktu_selesai.slice(0, 5));  // Set Waktu Selesai (format HH:mm)
                    $('#edit_ruangan').val(response.ruangan);  // Set Ruangan
                    $('#edit_batas_waktu_upload_soal').val(response.batas_waktu_upload_soal);
                    // Menampilkan modal edit
                    $('#editModal').modal('show');
                },
                error: function(xhr) {
                    // Jika terjadi error
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        }

        function hapusUjian(id) {
            Swal.fire({
                title: "Anda yakin?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-light"
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('ujian.delete', ':ujian') }}".replace(':ujian', id),
                        method: 'DELETE',
                        data: {
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "OK"
                            }).then(() => {
                                location.reload(); // Reload page after delete
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: xhr.responseJSON.message || "Terjadi kesalahan saat menghapus ujian.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        }

        function uploadKopSoal(ujian_id) {
            $('#ujian_id').val(ujian_id);
            $('#uploadKopSoalModal').modal('show');
        }

        function submitFormUpload() {
            var ujian_id = $('#ujian_id').val();
            var formData = new FormData(document.getElementById('formUploadKopSoal'));

            $.ajax({
                url: '{{ route("ujian.upload", ":ujian") }}'.replace(':ujian', ujian_id),  // Route dengan parameter ujian
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload();  // Refresh halaman setelah upload
                    });
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Error!",
                        text: "Terjadi kesalahan saat upload kop soal.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            });
        }

    </script>
@endpush
