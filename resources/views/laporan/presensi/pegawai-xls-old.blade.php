<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Laporan Pegawai</title>
    <meta name="generator" content="LibreOffice 7.2.5.2 (Linux)" />
    <meta name="created" content="2022-05-07T13:02:00" />
    <meta name="changed" content="2022-06-22T20:09:28" />
    <meta name="KSOProductBuildVer" content="1033-3.2.0.6370" />

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
            font-family: "Times New Roman";
            font-size: x-small
        }
    </style>

</head>

<body>
    <table>
        <tr>
            <td colspan=14 height="20" align="center" valign=bottom><b>
                    <font face="Arial" size=1>DRAFT RINCIAN KEHADIRAN
                    </font>
                </b></td>
        </tr>
        @php
            $hariKerja = hari_kerja($bulan, $tahun);
            $logo = get_logo();
        @endphp
        <tr>
            <td colspan=14 height="20" align="left" valign=middle><b>
                    <font face="Arial" size=1>TANGGAL CETAK : {{ strtoupper(tanggal_indo(date('Y-m-d'))) }}</font>
                </b>

                {{-- <span style="float:right;">
                    <img style="width:60px;" src="{{ asset("storage/$logo") }}" alt="logo" />
                </span>
                <br />
                <br />
                <br />
                <br /> --}}
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="20" align="left" valign=top><b>
                    <font face="Arial" size=1>NO PEGAWAI</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $pegawai->nip }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="20" align="left" valign=top><b>
                    <font face="Arial" size=1>NAMA</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $pegawai->name }}</font>
                </b></td>
        </tr>
        @php
            
            $jabatan = array_key_exists('0', $pegawai->jabatan_akhir->toArray()) ? $pegawai->jabatan_akhir[0] : null;
            
            $skpd = $jabatan?->skpd?->nama;
            $nama_jabatan = $jabatan?->tingkat?->nama;
        @endphp
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="20" align="left" valign=top><b>
                    <font face="Arial" size=1>JABATAN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $nama_jabatan }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="20" align="left" valign=top><b>
                    <font face="Arial" size=1>DIVISI</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $skpd }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="20" align="left" valign=top><b>
                    <font face="Arial" size=1>BULAN / TAHUN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ strtoupper(bulan($bulan)) }} / {{ $tahun }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                height="20" align="right" valign=top><b>
                    <font face="Arial" size=1>No</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" width="15"
                align="left" valign=top><b>
                    <font face="Arial" size=1>Hari</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=2 align="left" valign=top><b>
                    <font face="Arial" size=1>Tanggal</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Awal</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Akhir</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Masuk</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Keluar</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Telat</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" width="20"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Pulang Awal</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Break</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" width="20"
                align="center" valign=top><b>
                    <font face="Arial" size=1>After Break</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" width="20"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Telat Kembali</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" width="30"
                align="left" valign=top><b>
                    <font face="Arial" size=1>Keterangan</font>
                </b></td>
        </tr>
        @php
            $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        @endphp

        @for ($i = 1; $i <= $number; $i++)
            @php
                $day = date('Y-m-d', strtotime("$tahun-$bulan-$i"));
                $data = kehadiran_pegawai_free("$tahun-$bulan-$i", $pegawai->nip);
            @endphp
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    width="12" height="20" align="center" valign=top sdval="1">
                    <font face="Arial" size=1 color="#000000">{{ $i }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    width="10" align="left" valign=top>
                    <font face="Arial" size=1>{{ hari(date('w', strtotime($day))) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=top>
                    <font face="Arial" size=1> {{ tanggal_indo($day) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1 color="#000000">{{ get_jam($data->rule_datang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1 color="#000000">{{ get_jam($data->rule_pulang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1>{{ get_jam($data->jam_datang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1>{{ get_jam($data->jam_pulang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1>{{ hitung_jam_menit_detik_dari_2_jam($data->rule_datang, $data->jam_datang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1>{{ hitung_jam_menit_detik_dari_2_jam($data->rule_pulang, $data->jam_pulang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1>{{ get_jam($data->jam_istirahat_mulai) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1 color="#000000">{{ get_jam($data->jam_istirahat_selesai) }}</font>
                </td>
                @php
                    $telat = "-";
                    $menit_istirahat = menit_dari_2jam($data->jam_istirahat_mulai, $data->jam_istirahat_selesai);
                    if($menit_istirahat > $data->rule_istirahat){
                        $telat = $menit_istirahat - $data->rule_istirahat;
                    }
                @endphp
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="center" valign=top>
                    <font face="Arial" size=1>{{ menit_to_jam_menit_detik($telat) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="left" valign=middle>
                    <font color="#000000">-</font>
                </td>
            </tr>
        @endfor

        <tr>
            <td colspan="7"></td>
            <td colspan=7 height="150" align="center" valign=bottom><b>
                    <br>
                    <br>
                    <font face="Arial" size=1>JOMBANG , {{ strtoupper(tanggal_indo(date('Y-m-d'))) }}
                    </font>
                    <br>
                    <br>
                    <br>
                    <br>
                    <font face="Arial" size=1><u>{{ $pegawai->name }}</u></font>
                    <br>
                    <font face="Arial" size=1>{{ $pegawai->nip }}</font>
                </b></td>
        </tr>
    </table>
</body>

</html>
