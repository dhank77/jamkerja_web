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
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>

</head>

<body>
    <table cellspacing="0" border="0" width="100%" border="1">
        <tr>
            <td colspan=14 height="10" align="center" valign=bottom><b>
                    <font face="Arial" size=1>DRAFT RINCIAN KEHADIRAN
                    </font>
                </b></td>
        </tr>
        @php
            $hariKerja = hari_kerja($bulan, $tahun);
            $logo = get_logo();
        @endphp
        <tr>
            <td colspan=14 height="15" align="left" valign=middle><b>
                    <font face="Arial" size=1>TANGGAL CETAK : {{ strtoupper(tanggal_indo(date('Y-m-d'))) }}</font>
                </b>

                <span style="float:right;">
                    <img style="width:60px;" src="{{ asset("storage/$logo") }}" alt="logo" />
                </span>
                <br />
                <br />
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>NO PEGAWAI</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $pegawai->nip }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
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
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>JABATAN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $nama_jabatan }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>DIVISI</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ $skpd }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=4 height="12" align="left" valign=top><b>
                    <font face="Arial" size=1>BULAN / TAHUN</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=10 align="left" valign=top><b>
                    <font face="Arial" size=1>: {{ strtoupper(bulan($bulan)) }} / {{ $tahun }}</font>
                </b></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                height="12" align="right" valign=top><b>
                    <font face="Arial" size=1>No</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="left" valign=top><b>
                    <font face="Arial" size=1>&nbsp;&nbsp;Hari</font>
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
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Pulang Awal</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Break</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>After Break</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="center" valign=top><b>
                    <font face="Arial" size=1>Telat Kembali</font>
                </b></td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                align="left" valign=top><b>
                    <font face="Arial" size=1>Keterangan</font>
                </b></td>
        </tr>
        @php
            $bulanR = $bulan;
            $tahunR = $tahun;
            if ($bulan == 1) {
                $bulaniM = 12;
                $tahunIm = $tahun - 1;
                $numberM1 = cal_days_in_month(CAL_GREGORIAN, 12, $tahunIm);
            } else {
                $bulaniM = $bulan - 1;
                $tahunIm = $tahun;
                $numberM1 = cal_days_in_month(CAL_GREGORIAN, $bulan - 1, $tahun);
            }
            $number = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
            $no = 1;
            $hari_kerja = 0;
            $hari_libur = 0;
            $total_telat = '00:00:00';
            $total_pulang_awal = '00:00:00';
            $total_telat_kembali = '00:00:00';
        @endphp

        @for ($iM = 26 - $numberM1; $iM <= 25; $iM++)
            @php
                if ($iM < 1) {
                    $i = $numberM1 + $iM;
                    $bulan = $bulaniM;
                    $tahun = $tahunIm;
                } else {
                    $bulan = $bulanR;
                    $tahun = $tahunR;
                    $i = $iM;
                }
                $day = date('Y-m-d', strtotime("$tahun-$bulan-$i"));
                $data = kehadiran_pegawai_free("$tahun-$bulan-$i", $pegawai->nip);
                $keterangan = '';
                $libur = check_libur_master("$tahun-$bulan-$i", $pegawai->nip, $data->status);
                if ($libur) {
                    $hari_libur += 1;
                    $keterangan .= $keterangan == '' ? 'Libur' : ', Libur';
                } else {
                    $kunjungan = kunjungan_pegawai("$tahun-$bulan-$i", $pegawai->nip);
                    if ($kunjungan) {
                        $keterangan .= $keterangan == '' ? "Kunjungan ke $kunjungan" : ", Kunjungan ke $kunjungan";
                    }
                    $cuti = pengajuan_pegawai('App\Models\Pegawai\DataPengajuanCuti', "$tahun-$bulan-$i", $pegawai->nip);
                    if ($cuti) {
                        $keterangan .= $keterangan == '' ? 'Cuti' : ', Cuti';
                    }
                    $ijin = pengajuan_pegawai('App\Models\Pengajuan\PengajuanIjin', "$tahun-$bulan-$i", $pegawai->nip);
                    if ($ijin) {
                        $keterangan .= $keterangan == '' ? 'Ijin' : ', ijin';
                    }
                    $izin = pengajuan_pegawai('App\Models\Pengajuan\PengajuanIzin', "$tahun-$bulan-$i", $pegawai->nip);
                    if ($izin) {
                        $keterangan .= $keterangan == '' ? 'Izin' : ', izin';
                    }
                    $sakit = pengajuan_pegawai('App\Models\Pengajuan\PengajuanSakit', "$tahun-$bulan-$i", $pegawai->nip);
                    if ($sakit) {
                        $keterangan .= $keterangan == '' ? 'Sakit' : ', Sakit';
                    }
                    if ($cuti == null && $ijin == null && $izin == null && $sakit == null && $kunjungan == null) {
                        $hari_kerja += 1;
                        if ($data->jam_datang == '') {
                            $keterangan .= $keterangan == '' ? 'TCM' : ', TCM';
                        }
                        if ($data->jam_pulang == '') {
                            $keterangan .= $keterangan == '' ? 'TCP' : ', TCP';
                        }
                        if ($data->jam_istirahat_mulai == '') {
                            $keterangan .= $keterangan == '' ? 'TCB' : ', TCB';
                        }
                        if ($data->jam_istirahat_selesai == '') {
                            $keterangan .= $keterangan == '' ? 'TCAB' : ', TCAB';
                        }
                    }
                }
                
                $telat = hitung_jam_menit_detik_dari_2_jam($data->rule_datang, $data->jam_datang);
                $pulang_awal = hitung_jam_menit_detik_dari_2_jam($data->jam_pulang, $data->rule_pulang);
                
                $telat_istirahat = '-';
                $menit_istirahat = menit_dari_2jam($data->jam_istirahat_mulai, $data->jam_istirahat_selesai);
                if ($menit_istirahat > $data->rule_istirahat) {
                    $telat_istirahat = $menit_istirahat - $data->rule_istirahat;
                }
                $telat_kembali = menit_to_jam_menit_detik($telat_istirahat);
                
                $total_telat = menjumlahkan_menit($total_telat, $telat);
                $total_pulang_awal = menjumlahkan_menit($total_pulang_awal, $pulang_awal);
                $total_telat_kembali = menjumlahkan_menit($total_telat_kembali, $telat_kembali);
            @endphp
            <tr>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    width="12" height="12" align="center" valign=top sdval="1">
                    <font face="Arial" size=1 color="#000000">{{ $no++ }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    width="32" align="left" valign=top>
                    <font face="Arial" size=1>{{ hari(date('w', strtotime($day))) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                    colspan=2 align="center" valign=top>
                    <font face="Arial" size=1> {{ tanggal_indo($day) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                    <font face="Arial" size=1 color="#000000">{{ get_jam($data->rule_datang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                    <font face="Arial" size=1 color="#000000">{{ get_jam($data->rule_pulang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top>
                    <font face="Arial" size=1>{{ get_jam($data->jam_datang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top>
                    <font face="Arial" size=1>{{ get_jam($data->jam_pulang) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top>
                    <font face="Arial" size=1>
                        {{ $telat }}</font>
                </td>
                {{-- telat pulang --}}
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top>
                    <font face="Arial" size=1>
                        {{ $pulang_awal }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top>
                    <font face="Arial" size=1>{{ get_jam($data->jam_istirahat_mulai) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top sdval="0" sdnum="1033;0;H:MM:SS;@">
                    <font face="Arial" size=1 color="#000000">{{ get_jam($data->jam_istirahat_selesai) }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                    valign=top>
                    <font face="Arial" size=1>{{ $telat_kembali }}</font>
                </td>
                <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                    align="left" valign=middle>
                    <font color="#000000">{{ $keterangan == 'TCM, TCP, TCB, TCAB' ? "Tidak Hadir" : $keterangan }}</font>
                </td>
            </tr>
        @endfor
        <tr>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                width="12" height="12" align="center" valign=top sdval="1">
                <font face="Arial" size=1 color="#000000"></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                width="32" align="left" valign=top>
                <font face="Arial" size=1></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000"
                colspan=2 align="center" valign=top>
                <font face="Arial" size=1></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                <font face="Arial" size=1 color="#000000"></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top sdval="0.364213" sdnum="1033;0;H:MM:SS;@">
                <font face="Arial" size=1 color="#000000"></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top>
                <font face="Arial" size=1></font>
                </font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top>
                <font face="Arial" size=1></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top>
                <font face="Arial" size=1>
                    {{ $total_telat }}</font>
            </td>
            {{-- telat pulang --}}
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top>
                <font face="Arial" size=1>
                    {{ $total_pulang_awal }}</font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top>
                <font face="Arial" size=1></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top sdval="0" sdnum="1033;0;H:MM:SS;@">
                <font face="Arial" size=1 color="#000000"></font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;
                    align="center"
                valign=top>
                <font face="Arial" size=1>{{ $total_telat_kembali }}</font>
            </td>
            <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000;"
                align="left" valign=middle>
                <font color="#000000"></font>
            </td>
        </tr>

        <tr>
            <td colspan="8"></td>
            <td colspan=6 height="30" align="center" valign=bottom><b>
                    <font face="Arial" size=1>JOMBANG , {{ strtoupper(tanggal_indo(date('Y-m-d'))) }}
                        {{-- </font>
                    <br>
                    <br>
                    <br>
                    <br>
                    <font face="Arial" size=1><u>{{ $pegawai->name }}</u></font>
                    <br>
                    <font face="Arial" size=1>{{ $pegawai->nip }}</font> --}}
                </b></td>
        </tr>
    </table>
    <div class="page-break"></div>
    <table cellspacing="0" border="0" width="100%">
        {{-- <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000">Angelina Joli</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Angelina Joli</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Angelina Joli</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Angelina Joli</font>
            </td>
        </tr>
        <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000">Jabatan</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Jabatan</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Jabatan</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Jabatan</font>
            </td>
        </tr> --}}
        <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Keterangan :</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Total Hari Kerja</font>
            </td>
            <td align="right" valign=middle sdval="28" sdnum="1033;">
                <font color="#000000">{{ $hari_kerja }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Total Hari Libur</font>
            </td>
            <td align="right" valign=middle sdval="0" sdnum="1033;">
                <font color="#000000">{{ $hari_libur }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Total Hari Lembur</font>
            </td>
            <td align="right" valign=middle sdval="1" sdnum="1033;">
                <font color="#000000">{{ count_lembur($pegawai->nip, "$tahunIm-$bulaniM-26", "$tahunR-$bulanR-25") }}
                </font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Total Potongan Hari Tidak Masuk Kerja</font>
            </td>
            <td align="right" valign=middle sdval="2" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        @php
            $potongan = get_potongan_absensi($pegawai->nip, $bulan, $tahun)
        @endphp
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Total Denda Keterlambatan</font>
            </td>
            <td align="right" valign=middle sdval="3" sdnum="1033;">
                <font color="#000000">Rp. {{ number_indo($potongan['telat']) }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=4 height="10" align="left" valign=middle>
                <font color="#000000">Total Tidak Ceklok</font>
            </td>
            <td style="border-bottom: 1px solid #000000" align="right" valign=middle sdval="3" sdnum="1033;">
                <font color="#000000">Rp. {{ number_indo($potongan['ceklok']) }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td colspan=2 align="left" valign=middle>
                <font color="#000000">Total Potongan</font>
            </td>
            <td align="right" valign=middle sdval="4" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td colspan=2 align="left" valign=middle>
                <font color="#000000">Total Lembur</font>
            </td>
            <td align="right" valign=middle sdval="5" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        @php
            $cuti = perhitungan_cuti_tahunan($pegawai->nip, date('Y', strtotime("$tahunR-$bulanR-26")));
        @endphp
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">Hak Cuti Tahunan</font>
            </td>
            <td align="right" valign=middle sdval="6" sdnum="1033;">
                <font color="#000000">{{ $cuti['total'] }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">Sisa Cuti</font>
            </td>
            <td align="right" valign=middle sdval="8" sdnum="1033;">
                <font color="#000000">{{ $cuti['total'] - $cuti['hari'] }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
        </tr>
        <tr>
            <td height="10" align="left" valign=middle>
                <font color="#000000">Report Ijin :</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="right" valign=middle sdval="5" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">-Cuti yang sudah diambil</font>
            </td>
            <td align="right" valign=middle sdval="4" sdnum="1033;">
                <font color="#000000">{{ $cuti['hari'] }}</font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td colspan=3 align="left" valign=middle>
                <font color="#000000">{{ $cuti['tanggal_mulai_selesai'] }}</font>
            </td>
        </tr>
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">- Ijin Potong Cuti</font>
            </td>
            <td align="right" valign=middle sdval="3" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td colspan=3 align="center" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">- Sakit</font>
            </td>
            <td align="right" valign=middle sdval="2" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td colspan=3 align="center" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">- Ijin Potong Gaji</font>
            </td>
            <td align="right" valign=middle sdval="1" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td colspan=3 align="center" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">- Ijin Tidak Potong Gaji</font>
            </td>
            <td align="right" valign=middle sdval="0" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td colspan=3 align="center" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
        <tr>
            <td colspan=2 height="10" align="left" valign=middle>
                <font color="#000000">- Potongan Libur Kena SP</font>
            </td>
            <td align="right" valign=middle sdval="9" sdnum="1033;">
                <font color="#000000"></font>
            </td>
            <td align="left" valign=middle>
                <font color="#000000">&nbsp;&nbsp;Hari</font>
            </td>
            <td colspan=3 align="center" valign=middle>
                <font color="#000000"><br></font>
            </td>
        </tr>
    </table>
</body>

</html>
