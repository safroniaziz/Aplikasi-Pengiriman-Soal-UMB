<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ujian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Laporan Ujian</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>Prodi</th>
                <th>Pelaksanaan</th>
                <th>Status</th>
                <th>Kop Soal</th>
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
                        @php
                            $now = \Carbon\Carbon::now();
                            $waktuMulai = \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->setTimeFromTimeString($ujian->waktu_mulai);
                            $waktuSelesai = \Carbon\Carbon::parse($ujian->tanggal_dilaksanakan)->setTimeFromTimeString($ujian->waktu_selesai);
                        @endphp

                        @if ($now->greaterThan($waktuSelesai))
                            Berakhir
                        @elseif ($now->between($waktuMulai, $waktuSelesai))
                            Sedang Berlangsung
                        @else
                            Belum Berlangsung
                        @endif
                    </td>
                    <td>
                        @if($ujian->kopSoalUjian)
                            Ada
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->format('d-m-Y H:i') }}</td>
                    <td>{{ $ujian->pengupload->nama_lengkap }}</td>
                    <td>
                        @if($ujian->soalUjian)
                            Ada
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td>
                        @if ($ujian->soalUjian && $ujian->soalUjian->validasi)
                            {{ $ujian->soalUjian->validasi->status }}
                        @else
                            Belum Divalidasi
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
