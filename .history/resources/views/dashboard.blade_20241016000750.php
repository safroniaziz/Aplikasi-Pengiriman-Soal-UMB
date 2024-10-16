@extends('layouts.layouts')
@section('halaman')
    <li class="breadcrumb-item text-white opacity-75">Dashboard</li>
@endsection
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <!--begin::Col-->
            <div class="col-xxl-12">
                <!--begin::Engage widget 8-->
                <div class="card border-0 h-md-100" data-bs-theme="light" style="background: linear-gradient(112.14deg, #00D2FF 0%, #3A7BD5 100%)">
                    <!--begin::Body-->
                    <div class="card-body">
                        <!--begin::Row-->
                        <div class="row align-items-center h-100">
                            <!--begin::Col-->
                            <div class="col-7 ps-xl-13">
                                <!--begin::Title-->
                                <div class="text-white mb-6 pt-6">
                                    <span class="fs-2qx fw-bold">E-RISALAH</span>
                                </div>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <span class="fw-semibold text-white fs-6 mb-8 d-block opacity-75">Sistem Informasi Pengaduan dan Aspirasi Masyarakat Kabupaten Kepahiang</span>
                                <!--end::Text-->
                                <!--begin::Items-->
                                <!--end::Items-->
                                <!--begin::Action-->
                                <div class="d-flex flex-column flex-sm-row d-grid gap-2">
                                    <a href="{{ route('dashboard') }}" class="btn btn-success flex-shrink-0 me-lg-2" >Registrasi Rapat</a>
                                    <a href="{{ route('dashboard') }}" class="btn btn-primary flex-shrink-0" style="background: rgba(255, 255, 255, 0.2)" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Dokumen Rapat</a>
                                </div>
                                <!--end::Action-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-5 pt-10">
                                <!--begin::Illustration-->
                                <div class="bgi-no-repeat bgi-size-contain bgi-position-x-end h-225px" style="background-image:url({{ asset('assets/risalah/assets/media/svg/illustrations/easy/5.svg') }})"></div>
                                <!--end::Illustration-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Engage widget 8-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <!--begin::Col-->
            <div class="col-xl-12">
                <!--begin::Table widget 14-->
                <div class="card card-flush h-md-100">
                    <!--begin::Header-->
                    <div class="card-header pt-7">
                        <!--begin::Title-->
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-800">Data Anggota</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">Data anggota terdaftar dalam database</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-6">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fs-5 fw-bold text-gray-500 border-bottom-0">
                                        <th>No</th>
                                        <th>Nama Anggota</th>
                                        <th>Email</th>
                                        <th >Fraksi</th>
                                        <th>Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($anggotas as $index => $anggota)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $anggota->nama_lengkap }}</td>
                                            <td>{{ $anggota->email }}</td>
                                            <td>{{ $anggota->fraksi }}</td>
                                            <td>{{ $anggota->jabatan }}</td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                                <!--end::Table body-->
                            </table>

                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end: Card Body-->
                </div>
                <!--end::Table widget 14-->
            </div>
            <!--end::Col-->
        </div>
        <!--end::Row-->
    </div>
@endsection
