<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAPORAN IJIN</title>
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
        LAPORAN IJIN PEGAWAI
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
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:50px;">No</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:250px;">Nama</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:250px;">Jenis Ijin</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:100px;">Uploadan</th>
                @if ($jenis_laporan != 'harian')
                    <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:80px;">Jml Ijin</th>
                @endif
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:150px;">Created At</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:150px;">Check In</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:150px;">Check Out</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:150px;">Break</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:150px;">After Break</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:300px;">Note</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; width:300px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($data->chunk(50) as $key => $values)
                @foreach ($values as $value)
                    <tr>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:50px;">{{ $no++ }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;">&nbsp;&nbsp;{{ optional($value->user)->name }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;">&nbsp;&nbsp;{{ optional($value->ijin)->nama }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center; width:50px;">
                            @if ($value->file != '')
                                <a target="_blank" href="{{ storageNull($value->file) }}">@</a>
                            @endif
                        </td>
                        @if ($jenis_laporan != 'harian')
                            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;">{{ get_jumlah_pengajuan('App\Models\Pengajuan\PengajuanIjin', $value->nip, $tahun, $bulan) }}
                            </td>
                        @endif
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;">{{ tanggal_indo($value->created_at) }}</td>
                        @php
                            $presensi = get_presensi_ijin($value->nip, $value->tanggal_mulai);
                        @endphp
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">{{ get_jam($presensi->jam_datang) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">{{ get_jam($presensi->jam_pulang) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">{{ get_jam($presensi->jam_istirahat_mulai) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">{{ get_jam($presensi->jam_istirahat_selesai) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000">{{ $value->keterangan }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"></td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
