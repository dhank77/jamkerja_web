<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kehadiran Bulan</title>
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

        .text-center{
            text-align: center;
        }

    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px; font-weight:bold; margin-bottom:0px;">
        LAPORAN KEHADIRAN PEGAWAI
        <br>
        BULAN {{ strtoupper(bulan($bulan)) }} TAHUN {{ $tahun }}
        @if($kode)
            <br>
           DIVISI KERJA : {{ strtoupper(get_skpd($kode)) }}
        @endif
    </div>
    <br>
    <br>
    @php
        $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun); 
    @endphp
    <table border="1" width="100%">
        <thead>
            <tr>
                <th style="text-align:center;">No</th>
                <th style="text-align:center;">Nomor Pegawai</th>
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">Grade</th>
                <th>Tanggal <br> Masuk</th>
                <th>Lama <br> Bekerja</th>
                <th>Telat</th>
                <th>Pulang <br> Cepat</th>
                <th>Penyesuaian</th>
                <th>Total <br> Menit <br> Telat</th>
                <th>Libur</th>
                <th>Cuti</th>
                <th>Izin</th>
                <th>Ijin</th>
                <th>Sakit</th>
                <th>Denda SP</th>
                <th>Penyesuaian</th>
                <th>Kelebihan  <br> Libur</th>
                <th>Jml Hari <br> Kerja</th>
                <th>Rupiah  <br> Lebih Libur</th>
                <th>Total Rupiah</th>
                <th>Sisa Cuti</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach($pegawai->chunk(100) as $key => $values)
                @foreach($values as $value)
                    @php
                        //$kehadiran = kehadiran_free($value->nip, $bulan, $tahun);
                        $tgl_masuk = get_sk_jabatan_terlama($value->nip);
                        $perhitungan = perhitungan_sebulan($value->nip, $bulan, $tahun);
                        $cuti = perhitungan_cuti($value->nip, $bulan, $tahun, "App\Models\Pegawai\DataPengajuanCuti");
                        $izin = perhitungan_cuti($value->nip, $bulan, $tahun, "App\Models\Pengajuan\PengajuanIzin");
                        $ijin = perhitungan_cuti($value->nip, $bulan, $tahun, "App\Models\Pengajuan\PengajuanIjin");
                        $sakit = perhitungan_cuti($value->nip, $bulan, $tahun, "App\Models\Pengajuan\PengajuanSakit");
                        $cutiTahun = perhitungan_cuti_tahunan($value->nip, $tahun);
                    @endphp
                    <tr>
                        <td style="text-align:center;">{{ $no++ }}</td>
                        <td>&nbsp;&nbsp;{{ $value->nip }}</td>
                        <td>&nbsp;&nbsp;{{ $value->name }}</td>
                        <td>{{ get_level_from_nip($value->nip) }}</td>
                        <td>{{ date_indo($tgl_masuk) }}</td>
                        <td>{{ get_masa_kerja($tgl_masuk, true) }}</td>
                        <td>{{ $perhitungan['telat'] }}</td>
                        <td>{{ $perhitungan['cepat'] }}</td>
                        <td></td>
                        <td>{{ $perhitungan['telat'] + $perhitungan['cepat'] }}</td>
                        <td></td>
                        <td>{{ $cuti }}</td>
                        <td>{{ $izin }}</td>
                        <td>{{ $ijin }}</td>
                        <td>{{ $sakit }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td style="text-align:center;">{{ $cutiTahun['total'] - $cutiTahun['hari'] }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
