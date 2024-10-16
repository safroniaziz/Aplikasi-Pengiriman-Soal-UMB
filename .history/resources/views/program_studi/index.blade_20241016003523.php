@extends('layouts.layouts')
@section('halaman')
    <li class="breadcrumb-item text-white opacity-75">Program Studi</li>
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
                        <input type="text" data-kt-program-studi-table-filter="search" class="form-control form-control-solid w-250px ps-13" placeholder="Cari Kategori Anggota" />
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
                            Tambah Program Studi
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
                            <th>Kode Prodi</th>
                            <th>Nama Prodi</th>
                            <th>Jenjang</th>
                            <th>Visi</th>
                            <th>Misi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prodis as $index => $prodi)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>{{ $prodi->kode_prodi }}</td>
                                <td>{{ $prodi->nama_prodi }}</td>
                                <td>{{ $prodi->jenjang }}</td>
                                <td>{{ $prodi->visi }}</td>
                                <td>{{ $prodi->misi }}</td>
                                <td>
                                    <div class="d-flex justify-content-between gap-2">
                                        <button type="button" class="btn btn-sm btn-primary" onclick="editProdi({{ $prodi->id }}, '{{ $prodi->nama_prodi }}')">Edit</button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="hapusProdi({{ $prodi->id }})">Hapus</button>
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
        @include('program_studi._modal_tambah')
        @include('program_studi._modal_edit')
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
                $('#formProdi')[0].reset();
            });
        });

        function editProdi(id, namaProdi) {
            $('#prodi_id').val(id);
            $('#edit_nama_prodi').val(namaProdi);
            $('#editModal').modal('show');
        }

        function hapusProdi(id) {
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
                        url: "{{ route('prodi.delete', ':programStudi') }}".replace(':programStudi', id),
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
                                text: xhr.responseJSON.message || "Terjadi kesalahan saat menghapus program studi.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });
                }
            });
        }
    </script>
@endpush
