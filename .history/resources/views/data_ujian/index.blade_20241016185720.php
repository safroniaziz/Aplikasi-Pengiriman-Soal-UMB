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
                            <th>Status Ujian</th>
                            <th>Ruangan</th>
                            <th>Batas Upload Soal</th>
                            <th>Kop Soal Ujian</th>
                            <th>Pengupload</th>
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
                                        <a href="{{ Storage::url($ujian->kopSoalUjian->path_file) }}" target="_blank"><i class="fa fa-check-circle"></i>&nbsp; Download {{ $ujian->kopSoalUjian->nama_file }}</a>
                                        <br>
                                        <button class="btn btn-sm btn-primary" onclick="updateKopSoal({{ $ujian->id }})">Edit</button>
                                    @elseif($now->lessThan($waktuMulai))
                                        <!-- Form Upload Kop Soal jika belum dimulai -->
                                        <button class="btn btn-sm btn-primary" onclick="uploadKopSoal({{ $ujian->id }})">Upload</button>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Upload Ditutup</button>
                                    @endif
                                </td>
                                <td>{{ $ujian->pengupload->nama_lengkap }}</td>
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
        @include('data_ujian._modal_edit_kop_soal')
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

        $(document).on('change', '#edit_mata_kuliah_id', function() {
            var prodiId = $(this).find(':selected').data('prodi-id');  // Ambil prodi_id dari mata kuliah yang dipilih

            // AJAX request untuk mengambil dosen berdasarkan prodi_id
            $.ajax({
                url: "{{ route('ujian.getDosenByProdi', ':prodi_id') }}".replace(':prodi_id', prodiId),
                method: 'GET',
                success: function(response) {
                    // Hapus opsi lama pada dropdown dosen
                    $('#edit_pengupload_id').empty();
                    $('#edit_pengupload_id').append('<option value="" disabled selected>Pilih dosen</option>');

                    // Tambahkan opsi dosen yang diambil dari server
                    $.each(response, function(index, dosen) {
                        $('#edit_pengupload_id').append('<option value="'+ dosen.id +'">'+ dosen.nama_lengkap +'</option>');
                    });
                },
                error: function(xhr) {
                    console.log("Error saat mengambil dosen:", xhr);
                }
            });
        });

        function editUjian(id) {
            $.ajax({
                url: '{{ route("ujian.edit", ":id") }}'.replace(':id', id),  // Menggunakan route name 'ujian.edit'
                type: 'GET',
                success: function(response) {
                    // Mengisi data ke dalam form edit
                    $('#ujian_id').val(response.id);
                    $('#edit_mata_kuliah_id').val(response.mata_kuliah_id);  // Set Mata Kuliah
                    $('#edit_tanggal_dilaksanakan').val(response.tanggal_dilaksanakan);  // Set Tanggal Ujian
                    $('#edit_waktu_mulai').val(response.waktu_mulai.slice(0, 5));  // Set Waktu Mulai (format HH:mm)
                    $('#edit_waktu_selesai').val(response.waktu_selesai.slice(0, 5));  // Set Waktu Selesai (format HH:mm)
                    $('#edit_ruangan').val(response.ruangan);  // Set Ruangan
                    $('#edit_batas_waktu_upload_soal').val(response.batas_waktu_upload_soal);

                    // Ambil data dosen pengupload soal berdasarkan prodi_id
                    var prodiId = $('#edit_mata_kuliah_id').find(':selected').data('prodi-id');
                    $.ajax({
                        url: "{{ route('ujian.getDosenByProdi', ':prodi_id') }}".replace(':prodi_id', prodiId),
                        method: 'GET',
                        success: function(dosenResponse) {
                            // Kosongkan dropdown dosen lama
                            $('#edit_pengupload_id').empty();
                            $('#edit_pengupload_id').append('<option value="" disabled>Pilih dosen</option>');

                            // Tambahkan opsi dosen yang diambil dari server
                            $.each(dosenResponse, function(index, dosen) {
                                $('#edit_pengupload_id').append('<option value="'+ dosen.id +'">'+ dosen.nama_lengkap +'</option>');
                            });

                            // Setelah dropdown terisi, pilih pengupload_id yang sudah ada
                            $('#edit_pengupload_id').val(response.pengupload_id);
                        },
                        error: function(xhr) {
                            console.log("Error saat mengambil dosen:", xhr);
                        }
                    });

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

        function updateKopSoal(ujian_id) {
            console.log("Fungsi updateKopSoal dipanggil untuk Ujian ID:", ujian_id);  // Debugging
            // Ambil data kop soal dari server dan isi form
            $.ajax({
                url: '{{ route("ujian.getKopSoal", ":ujian") }}'.replace(':ujian', ujian_id),  // Route untuk mendapatkan data kop soal
                method: "GET",
                success: function(response) {
                    console.log("Data kop soal diterima:", response);  // Debugging
                    // Isi form dengan data kop soal yang sudah ada
                    $('#edit_ujian_id').val(response.ujian_id);
                    $('#edit_nama_file').val(response.nama_file);
                    $('#editKopSoalModal').modal('show');
                },
                error: function(xhr) {
                    console.log("Error saat mengambil data kop soal:", xhr);  // Debugging
                    alert('Terjadi kesalahan saat mengambil data kop soal.');
                }
            });
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

        function submitEditForm() {
            var formData = new FormData(document.getElementById('formEditUjian'));
            var ujianId = $('#edit_ujian_id').val();  // Ambil ID ujian yang sedang di-edit

            $.ajax({
                url: "{{ route('ujian.update', ':id') }}".replace(':id', ujianId),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),  // Token CSRF
                    'X-HTTP-Method-Override': 'PATCH'  // Override ke PATCH
                },
                success: function(response) {
                    Swal.fire({
                        title: "Sukses!",
                        text: "Data ujian berhasil diperbarui.",
                        icon: "success",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(() => {
                        // Tutup modal setelah berhasil
                        $('#editModal').modal('hide');
                        location.reload();  // Refresh halaman
                    });
                },
                error: function(xhr) {
                    let errorMessage = "Terjadi kesalahan saat memperbarui data!";
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        title: "Error!",
                        text: errorMessage,
                        icon: "error",
                        confirmButtonText: "OK",
                        customClass: {
                            confirmButton: "btn btn-danger"
                        }
                    });
                }
            });
        }



    </script>
@endpush
