<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN KUNJUNGAN</title>
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
        LAPORAN KUNJUNGAN
        <br>

         @if ($jenis_laporan == 'harian')
            {{ tanggal_indo($tanggal) }}
        @elseif($jenis_laporan == 'bulanan')
            BULAN {{ strtoupper(bulan($bulan)) }} TAHUN {{ $tahun }}
        @elseif($jenis_laporan == 'periode_tertentu')
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
                <th style="text-align:center;">Judul</th>
                <th style="text-align:center;">Keterangan</th>
                <th style="text-align:center;">Uploadan</th>
                <th>Created At</th>
                <th>Kordinat</th>
                <th>Lokasi</th>
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
                        <td>&nbsp;&nbsp;{{ $value->judul }}</td>
                        <td>&nbsp;&nbsp;{{ $value->keterangan }}</td>
                        <td style="text-align:center;">
                            @if ($value->foto != '')
                                <a target="_blank" href="{{ storageNull($value->foto) }}">@</a>
                            @endif
                        </td>
                        <td>{{ tanggal_indo($value->tanggal) }}</td>
                        <td>{{ $value->kordinat }}</td>
                        <td>{{ $value->lokasi }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
