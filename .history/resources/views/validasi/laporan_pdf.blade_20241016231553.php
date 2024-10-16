<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ujian</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #555;
        }

        /* Styling table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #3d3d3d; /* Dark gray header for better readability */
            color: white;
            text-align: left;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* Alternate row color */
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 30px;
            color: #333;
            border-bottom: 2px solid #3d3d3d; /* Dark gray section separator */
            padding-bottom: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
            color: #888;
        }

        /* Improved Styling for Section */
        .risalah-container {
            margin-top: 30px;
        }

        .risalah-header {
            background-color: #f5f5f5;
            padding: 10px;
            margin-bottom: 10px;
            border-left: 5px solid #3d3d3d;
        }

        .risalah-header h4 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .risalah-body {
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .risalah-body p {
            margin: 0;
            font-size: 12px;
            color: #555;
        }

        .risalah-body p + p {
            margin-top: 10px;
        }

        .no-risalah {
            text-align: center;
            color: #999;
            font-style: italic;
            padding: 15px;
            border: 1px dashed #ccc;
            background-color: #f9f9f9;
        }

        .signature-section {
            margin-top: 50px;
            text-align: right;
        }

        .signature-right {
            width: 250px; /* Adjust the width as needed */
            float: right; /* Align the signature to the right side */
            text-align: center; /* Center text within the signature box */
            margin-top: 50px;
        }

        .date {
            margin-bottom: 20px; /* Spacing between date and signature */
        }

        .signature {
            text-decoration: underline;
            font-weight: bold;
            margin-bottom: 5px;
        }

    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Ujian</h1>
            Dibuat pada {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y H:i') }}
    </div>

    <!-- Detail Ujian -->
    <div class="section-title">Detail Ujian</div>
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
                <th>Catatan Kaprodi</th> <!-- Tambahan kolom catatan Kaprodi -->
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
                            {{ ucfirst($ujian->soalUjian->validasi->status) }}
                        @else
                            Belum Divalidasi
                        @endif
                    </td>
                    <td>
                        @if ($ujian->soalUjian && $ujian->soalUjian->validasi && $ujian->soalUjian->validasi->catatan_kaprodi)
                            {{ $ujian->soalUjian->validasi->catatan_kaprodi }}
                        @else

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-right">
            <p class="date">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p class="signature">............</p>
            <br>
            <br>
            <br>
            <br>
            <br>
            <p>...............</p>
        </div>
    </div>

</body>
</html>
