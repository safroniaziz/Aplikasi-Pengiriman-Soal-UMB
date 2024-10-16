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
                        @if(Auth::user()->role == 'admin')
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                Tambah Ujian
                            </button>
                        @endif
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
                            <th>Kop Soal Ujian</th>
                            <th>Batas Upload Soal</th>
                            @if(Auth::user()->role == 'admin')
                            <th>Pengupload</th>
                            @endif
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
                                <td>{{ $ujian->ruangan }}</td>
                                <td>
                                    @if($ujian->kopSoalUjian)
                                        <a href="{{ Storage::url($ujian->kopSoalUjian->path_file) }}" target="_blank"><i class="fa fa-check-circle"></i>&nbsp; Download {{ $ujian->kopSoalUjian->nama_file }}</a>
                                        @if(Auth::user()->role == 'admin')
                                            <br>
                                            @if ($ujian->soalUjian)
                                                <p class="text-danger">Tidak bisa edit karna dosen sudah upload soal ujian</p>
                                            @else
                                                <button class="btn btn-sm btn-primary" onclick="updateKopSoal({{ $ujian->id }})">Edit</button>
                                            @endif
                                        @endif
                                    @elseif($now->lessThan($waktuMulai))
                                        <!-- Form Upload Kop Soal jika belum dimulai -->
                                        @if(Auth::user()->role == 'admin')
                                            <button class="btn btn-sm btn-primary" onclick="uploadKopSoal({{ $ujian->id }})">Upload</button>
                                        @else
                                            <p class="text-danger">Belum diupload oleh admin</p>
                                        @endif
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Upload Ditutup</button>
                                    @endif
                                </td>
                                @if (Auth::user()->role == "dosen")
                                    <td>
                                        {{ \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->setTimezone('Asia/Jakarta')->format('d-m-Y H:i') }}
                                        <br>
                                        @php
                                            $batasWaktu = \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->setTimezone('Asia/Jakarta');
                                            $sisaWaktu = $now->diff($batasWaktu);
                                        @endphp
                                        <small>
                                            @if($now->lessThan($batasWaktu))
                                                Tersisa: {{ $sisaWaktu->days }} hari, {{ $sisaWaktu->h }} jam, {{ $sisaWaktu->i }} menit
                                            @else
                                                Waktu upload telah berakhir
                                            @endif
                                        </small>
                                    </td>
                                @else
                                    <td>{{ \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->format('d-m-Y H:i') }}</td>
                                @endif
                                @if(Auth::user()->role == 'admin')
                                    <td>{{ $ujian->pengupload->nama_lengkap }}</td>
                                @endif
                                <td>
                                    @if (Auth::user()->role == "dosen")
                                        @if($ujian->soalUjian)
                                            <a href="{{ Storage::url($ujian->soalUjian->path_file) }}" target="_blank"><i class="fa fa-check-circle"></i>&nbsp; Download {{ $ujian->soalUjian->judul_soal }}</a>
                                            <br>
                                            <button class="btn btn-sm btn-primary" onclick="updateSoal({{ $ujian->id }})">Edit</button>
                                        @elseif($now->lessThan($waktuMulai))
                                            @if ($ujian->kopSoalUjian)
                                                <button class="btn btn-sm btn-primary" onclick="uploadSoalUjian({{ $ujian->id }})">Upload</button>
                                            @else
                                                <p class="text-danger">Harap tunggu admin upload kop soal ujian terlebih dahulu</p>
                                            @endif
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Upload Ditutup</button>
                                        @endif
                                    @else
                                        @if($ujian->soalUjian)
                                                <a href="{{ Storage::url($ujian->soalUjian->path_file) }}" target="_blank"><i class="fa fa-check-circle"></i>&nbsp; Download {{ $ujian->soalUjian->judul_soal }}</a>
                                        @else
                                            @if ($now->lessThan($waktuMulai))
                                                <p class="text-warning">Belum Diupload</p>
                                            @else
                                                <p class="text-danger">Tidak Diupload</p>
                                            @endif
                                        @endif
                                    @endif
                                </td>
                                @if(Auth::user()->role == 'admin')
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-primary" onclick="editUjian({{ $ujian->id }})">Edit</button>
                                            <button type="button" class="btn btn-sm btn-danger" onclick="hapusUjian({{ $ujian->id }})">Hapus</button>
                                        </div>
                                    </td>
                                @endif
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
