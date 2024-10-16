<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ujian</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #007BFF;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        th {
            background-color: #f4f4f4;
            font-weight: bold;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Style the headers */
        th {
            background-color: #007BFF;
            color: white;
        }

        .center-text {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Laporan Ujian</h1>
    <table>
        <thead>
            <tr>
                <th class="center-text">No</th>
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
                    <td class="center-text">{{ $index + 1 }}</td>
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
                    <td class="center-text">
                        @if($ujian->kopSoalUjian)
                            Ada
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($ujian->batas_waktu_upload_soal)->format('d-m-Y H:i') }}</td>
                    <td>{{ $ujian->pengupload->nama_lengkap }}</td>
                    <td class="center-text">
                        @if($ujian->soalUjian)
                            Ada
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td class="center-text">
                        @if ($ujian->soalUjian && $ujian->soalUjian->validasi)
                            {{ ucfirst($ujian->soalUjian->validasi->status) }}
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
