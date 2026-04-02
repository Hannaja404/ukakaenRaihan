<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Prasarana Sekolah</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            margin: 2rem;
        }

        h1 {
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin: 0;
            font-size: 2rem;
            color: #0f172a;
        }

        .subtitle {
            text-align: center;
            font-size: 14px;
            margin-bottom: 20px;
            color: #475569;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #e2e8f0;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #f8fafc;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #0f172a;
            border-bottom: 2px solid #0f172a;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            font-weight: bold;
            text-transform: uppercase;
            color: #94723c;
        }

        .btn-print {
            margin: 10px;
            padding: 8px 16px;
            background: #0f172a;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            th {
                background: #eee !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>
    <div class="no-print" style="text-align: center;">
        <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen</button>
        <a href="{{ route('admin.dashboard') }}" class="btn-print" style="background: #666;">Kembali ke Dasbor</a>
    </div>

    <h1>Laporan Rekapitulasi Pengaduan Siswa</h1>
    <div class="subtitle">Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</div>
    <div class="subtitle">Dicetak Oleh: {{ Auth::user()->name }} ({{ Auth::user()->role }})</div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal Pelaporan</th>
                <th width="20%">Data Pelapor</th>
                <th width="35%">Isi Aduan & Tanggapan</th>
                <th width="25%">Status & Riwayat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $index => $c)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($c->date)->translatedFormat('d M Y') }}</td>
                    <td>
                        <b>{{ $c->user->name }}</b><br>
                        NIK: {{ $c->user->nik }}<br>
                        Telp: {{ $c->user->phone }}
                    </td>
                    <td>
                        <b>Judul: {{ $c->title }}</b><br>
                        <p style="margin:5px 0;">{{ $c->description }}</p>
                        <hr>
                        @if($c->responses->count() > 0)
                            <b>Dibalas oleh: {{ $c->responses->last()->user->name }}</b><br>
                            <i>"{{ $c->responses->last()->response }}"</i>
                        @else
                            <i>Belum ada tanggapan</i>
                        @endif
                    </td>
                    <td>
                        Status: <span class="badge">{{ strtoupper($c->status) }}</span><br>
                        Terakhir diubah: {{ $c->updated_at->diffForHumans() }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right; font-size: 14px;">
        <p>Mengetahui,</p>
        <p style="margin-top: 80px;">___________________________</p>
        <p>Admin Sistem</p>
    </div>
</body>

</html>