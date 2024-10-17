@extends('layouts.layouts')
@section('halaman')
    <li class="breadcrumb-item text-white opacity-75">Dashboard</li>
@endsection
@section('content')
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <!--begin::Col-->
            <div class="col-xxl-6">
                <!--begin::Card widget 18-->
                <div class="card card-flush h-md-100">
                    <!--begin::Body-->
                    <div class="card-body py-9">
                        <!--begin::Row-->
                        <div class="row gx-9 h-100">
                            <!--begin::Col-->
                            <div class="col-sm-6 mb-10 mb-sm-0">
                                <!--begin::Image-->
                                <div class="bgi-no-repeat bgi-position-center bgi-size-cover card-rounded min-h-400px min-h-sm-100 h-100" style="background-size: 100% 100%;background-image:url({{ asset('assets/risalah/assets/media/stock/600x600/img-33.jpg') }})"></div>
                                <!--end::Image-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-sm-6">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column h-100">
                                    <!--begin::Header-->
                                    <div class="mb-7">
                                        <!--begin::Headin-->
                                        <div class="d-flex flex-stack mb-6">
                                            <!--begin::Title-->
                                            <div class="flex-shrink-0 me-5">
                                                <span class="text-gray-500 fs-7 fw-bold me-2 d-block lh-1 pb-1">PENGIRIMAN SOAL UJIAN</span>
                                                <span class="text-gray-800 fs-1 fw-bold">BERBASIS WEBSITE</span>
                                            </div>
                                        </div>
                                        <!--end::Heading-->
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Body-->
                                    <div class="mb-6">
                                        <!--begin::Text-->
                                        <span class="fw-semibold text-gray-600 fs-6 mb-8 d-block">Diajukan sebagai Salah Satu Syarat Skripsi untuk Memperoleh Kelulusan Jenjang Setara Satu pada Program Studi Teknik Informatika</span>
                                        <!--end::Text-->
                                        <!--begin::Stats-->

                                        <!--end::Stats-->
                                    </div>
                                    <!--end::Body-->
                                    <!--begin::Footer-->
                                    <div class="d-flex flex-stack mt-auto bd-highlight">
                                        <!--begin::Users group-->
                                        <div class="d-flex">
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 me-6 mb-3">
                                                <!--begin::Date-->
                                                <span class="fs-6 text-gray-700 fw-bold">Jumlah Prodi</span>
                                                <!--end::Date-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold text-gray-500">{{ $jumlahProdi }} Prodi</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                            <!--begin::Stat-->
                                            <div class="border border-gray-300 border-dashed rounded min-w-100px w-100 py-2 px-4 mb-3">
                                                <!--begin::Number-->
                                                <span class="fs-6 text-gray-700 fw-bold">Jumlah Dosen</span>
                                                <!--end::Date-->
                                                <!--begin::Label-->
                                                <div class="fw-semibold text-gray-500">{{ $jumlahDosen }} Orang</div>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Stat-->
                                        </div>
                                        <!--end::Users group-->

                                    </div>
                                    <!--end::Footer-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::Card widget 18-->
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xxl-6">
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
                                    <span class="fs-2qx fw-bold">SELAMAT DATANG</span>
                                </div>
                                <!--end::Title-->
                                <!--begin::Text-->
                                <span class="fw-semibold text-white fs-6 mb-8 d-block opacity-75">PENGIRIMAN DAN PENERIMAAN SOAL UJIAN
                                    FAKULTAS TEKNIK UNIVERSITAS MUHAMMADIYAH BENGKULU</span>
                                <!--end::Text-->
                                <!--begin::Items-->
                                <!--end::Items-->
                                <!--begin::Action-->
                                <div class="d-flex flex-column flex-sm-row d-grid gap-2">
                                    @if (Auth::user()->role == "kaprodi")
                                        <a href="{{ route('validasi') }}" class="btn btn-success flex-shrink-0 me-lg-2" >Validasi Soal</a>
                                    @else
                                        <a href="{{ route('ujian') }}" class="btn btn-success flex-shrink-0 me-lg-2" >Data Ujian</a>
                                    @endif
                                    <form action="{{ route('dashboard') }}" method="POST" id="logout-form">
                                        @csrf
                                        <button type="submit" class="btn btn-danger flex-shrink-0" style="background: rgba(255, 255, 255, 0.2)">Sign Out</button>
                                    </form>
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
                            <span class="card-label fw-bold text-gray-800">Data Aktivitas</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-6">15 data aktivitas terakhir yang dilakukan</span>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Toolbar-->
                    </div>

                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-6">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed align-middle gs-0 gy-3 my-0">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="fs-5 fw-bold text-gray-500 border-bottom-0">
                                        <th>No</th>
                                        <th>Log Name</th>
                                        <th>Description</th>
                                        <th>Subject Type</th>
                                        <th>Event</th>
                                        <th>Subject ID</th>
                                        <th>Properties</th>
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
