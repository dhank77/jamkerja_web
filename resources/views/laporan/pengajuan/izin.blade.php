<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN IZIN</title>
    <style>
        table,
        th,
        td {
            border-collapse: collapse;
        }
    </style>
    <style type="text/css">
        body,
        div,
        table,
        thead,
        tbody,
        tfoot,
        tr,
        th,
        td,
        p {
            font-family: "Calibri";
            font-size: x-small
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 14px; font-weight:bold; margin-bottom:0px;">
        @if($xls == 0)
            @php
                $logo = get_logo();
            @endphp
            <img style="width:40px;" src="{{ asset("storage/$logo") }}" alt="logo" />
            <br>
        @endif
        LAPORAN IZIN PEGAWAI
        <br>

         @if ($jenis_laporan == 'harian')
            {{ tanggal_indo($tanggal) }}
        @elseif($jenis_laporan == 'bulanan')
            BULAN {{ strtoupper(bulan($bulan)) }} TAHUN {{ $tahun }}
        @elseif($jenis_laporan == 'periode_tertentu')
            {{  strtoupper(tanggal_indo($tanggal_mulai)) . " - " . strtoupper(tanggal_indo($tanggal_selesai)) }}
        @elseif($jenis_laporan == 'periode')
        @php
                $bulanR = $bulan;
                $tahunR = $tahun;
                if ($bulan == 1) {
                    $bulaniM = 12;
                    $tahunIm = $tahun - 1;
                } else {
                    $bulaniM = $bulan - 1;
                    $tahunIm = $tahun;
                }
            @endphp
             {{  strtoupper(tanggal_indo("$tahunIm-$bulaniM-26")) . " - " . strtoupper(tanggal_indo("$tahunR-$bulanR-25")) }}
        @elseif($jenis_laporan == 'tahunan')
            TAHUN {{ $tahun }}
        @endif

    </div>
    <br>
    <br>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">Jenis Izin</th>
                <th style="text-align:center;">Uploadan</th>
                @if ($jenis_laporan != 'harian')
                    <th>Jml Izin</th>
                @endif
                <th>Created At</th>
                <th>Start</th>
                <th>End</th>
                <th>Jml Hari</th>
                <th>Note</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data->chunk(50) as $key => $values)
                @foreach ($values as $value)
                    <tr>
                        <td style="text-align:center;">{{ $no++ }}</td>
                        <td>&nbsp;&nbsp;{{ optional($value->user)->name }}</td>
                        <td>&nbsp;&nbsp;{{ optional($value->izin)->nama }}</td>
                        <td style="text-align:center;">
                            @if ($value->file != '')
                                <a target="_blank" href="{{ storageNull($value->file) }}">@</a>
                            @endif
                        </td>
                        @if ($jenis_laporan != 'harian')
                            <td>{{ get_jumlah_pengajuan('App\Models\Pengajuan\PengajuanIzin', $value->nip, $tahun, $bulan) }}
                            </td>
                        @endif
                        <td>{{ tanggal_indo($value->created_at) }}</td>
                        <td>{{ tanggal_indo($value->tanggal_mulai) }}</td>
                        <td>{{ tanggal_indo($value->tanggal_selesai) }}</td>
                        <td>{{ $value->hari }}</td>
                        <td>{{ $value->keterangan }}</td>
                        <td></td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
