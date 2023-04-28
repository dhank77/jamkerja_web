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
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:50px;">No</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:200px;">Nomor Pegawai</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:200px;">Nama</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:150px;">Grade</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:150px;">Tanggal <br> Masuk</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Lama <br> Bekerja</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Telat</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Pulang <br> Cepat</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Penyesuaian</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Total <br> Menit <br> Telat</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Libur</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Cuti</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Izin</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Ijin</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Sakit</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Denda SP</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Penyesuaian</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Kelebihan  <br> Libur</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Jml Hari <br> Kerja</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Rupiah  <br> Lebih Libur</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Total Rupiah</th>
                <th style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">Sisa Cuti</th>
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
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:50px;">{{ $no++ }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:200px;">&nbsp;&nbsp;{{ $value->nip }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:200px;">&nbsp;&nbsp;{{ $value->name }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:150px;">{{ get_level_from_nip($value->nip) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ date_indo($tgl_masuk) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ get_masa_kerja($tgl_masuk, true) }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $perhitungan['telat'] }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $perhitungan['cepat'] }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $perhitungan['telat'] + $perhitungan['cepat'] }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $cuti }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $izin }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $ijin }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $sakit }}</td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;"></td>
                        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000; text-align:center;width:100px;">{{ $cutiTahun['total'] - $cutiTahun['hari'] }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>

</html>
