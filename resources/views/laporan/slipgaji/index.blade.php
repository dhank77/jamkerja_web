<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>Slip Gaji - {{ $payroll->nip }}</title>
    <style>
        .padding1 {
            padding: 5px;
        }

        .padding2 {
            padding: 10px 8px;
        }
    </style>
</head>

<body>
    {{-- @php
        $name = $payroll->nip;
        $file_name = "slipgaji_$name.xlsx";
        if ($xls == 1) {
            header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=$file_name");
        }
    @endphp --}}
    {{-- <img class="img-fluid" src="{{ asset('logo.png') }}" width="80" height="30" alt="logo"> --}}
    <br><br><br>
    <table border="0" width="100%" cellspacing="0">
        @php
            $perusahan = getPerusahaan();
        @endphp
        <tbody>
            <tr>
                <td class="padding1"
                    style="border-top: 2px solid #000000; border-right: 2px solid #000000; border-left: 2px solid #000000; width:50%;"
                    colspan="2" align="justify" valign="center"><span
                        style="font-family: arial; color: #000000;"><strong> <span style="font-size: small;"><strong>
                                    {{ $perusahan->nama }}
                                </strong></span></strong><strong><span
                                style="font-size: small;"><strong></strong></span></strong></span></td>
                <td class="padding1"
                    style="border-top: 2px solid #000000; border-right: 2px solid #000000; width: 32.8125%;"
                    colspan="2" align="left" valign="center"><span
                        style="font-family: arial; color: #000000;"><span style="font-size: small;">No Pegawai
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $payroll->nip }} </span><span
                            style="font-size: small;"></span></span></td>
                <td class="padding1"
                    style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000; width: 30%;"
                    colspan="3" align="left" valign="top"><span
                        style="font-family: arial; font-size: small; color: #000000;">Divisi Kerja :
                        {{ $payroll->divisi }}
                    </span></td>
            </tr>
            <tr>
                <td class="padding1" style="border-left: 2px solid #000000; border-right: 2px solid #000000;"
                    colspan="2"><span style="font-family: arial; color: #000000;"><strong><span
                                style="font-size: small;"><strong>SLIP GAJI </strong></span></strong><strong><span
                                style="font-size: small;"><strong></strong></span></strong></span></td>
                <td class="padding1" style="width: 32.8125%;" colspan="2"><span
                        style="font-family: arial; color: #000000;"><span style="font-size: small;"><span
                                style="font-size: small;">Nama
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $payroll->user?->name }}
                            </span></span></span></td>
                <td class="padding1"
                    style="border-left: 2px solid #000000; border-right: 2px solid #000000; width: 30%;" colspan="3">
                    <span style="font-family: arial; color: #000000;"><span style="font-size: small;"><span
                                style="font-size: small;">Jabatan : {{ $payroll->jabatan }}</span></span></span>
                </td>
            </tr>
            <tr>
                <td class="padding1" style="border-left: 2px solid #000000; border-right: 2px solid #000000;"
                    colspan="2"><span style="font-family: arial; color: #000000;"><strong><span
                                style="font-size: small;"><strong> {{ $perusahan->alamat }} </strong>
                            </span>
                        </strong><strong><span style="font-size: small;"><strong></strong></span></strong></span></td>
                <td class="padding1" style="width: 32.8125%;" colspan="2"><span
                        style="font-family: arial; color: #000000;"><span style="font-size: small;">Status
                            &nbsp;&nbsp;&nbsp;: {!! is_aktif($payroll->is_aktif) !!}</span></span></td>
                <td class="padding1"
                    style="border-bottom: 2px solid #000000; border-left: 2px solid #000000; width: 14.2969%;"
                    align="left" valign="center"><span
                        style="font-family: arial; font-size: small; color: #000000;">Bulan
                        {{ bulan($payroll->bulan) }}
                    </span></td>
                <td class="padding1"
                    style="border-bottom: 2px solid #000000; border-right: 2px solid #000000; width: 25.0781%;"
                    colspan="2" align="left" valign="center"><span
                        style="font-family: arial; font-size: small; color: #000000;">Tahun {{ $payroll->tahun }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="padding2" style="border: 2px solid #000000;" colspan="2" align="center" valign="center">
                    <span style="font-family: arial; color: #000000;"><strong> <span style="font-size: small;">GAPOK &
                                PRESENSI</span> </strong></span>
                </td>
                <td class="padding2" style="border: 2px solid #000000; width: 32.8125%;" colspan="2" align="center"
                    valign="center"><span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">PENAMBAHAN</span> </strong></span></td>
                <td class="padding2" style="border: 2px solid #000000; width: 23.125%;" colspan="2" align="center"
                    valign="center"><span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">POTONGAN</span> </strong></span></td>
                <td class="padding2" style="border: 2px solid #000000; width: 16.25%;" align="center" valign="center">
                    <span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">PENERIMAAN</span> </strong></span>
                </td>
            </tr>
            <tr>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-left: 2px solid #000000; width: 16.0938%;"
                    align="left" valign="top">
                    <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">GAJI POKOK
                    </div>
                    @php
                        $kehadiran = kehadiran_free($payroll->nip, $payroll->bulan, $payroll->tahun);
                        $persen_kehadiran = $kehadiran['total_akhir'];
                    @endphp
                    <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">KEHADIRAN
                    </div>
                </td>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-right: 2px solid #000000; width: 11.7188%;"
                    align="right" valign="top">
                    <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">Rp.
                        {{ number_indo($payroll->gaji_pokok) }}</div>
                    <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">
                        {{ number_indo($persen_kehadiran) }} %</div>

                </td>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-left: 2px solid #000000; width: 16.0938%;"
                    align="left" valign="top">
                    <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">
                        TUNJANGAN JABATAN</div>
                    @foreach ($penambahan as $tambah)
                        <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">
                            {{ strtoupper($tambah->keterangan) }}</div>
                    @endforeach
                </td>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-right: 2px solid #000000; width: 11.7188%;"
                    align="right" valign="top">
                    <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">Rp.
                        {{ number_indo($payroll->tunjangan) }}</div>
                    @foreach ($penambahan as $tambah)
                        <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">Rp.
                            {{ number_indo($tambah->nilai) }}</div>
                    @endforeach
                </td>

                <td class="padding2"
                    style="border-top: 2px solid #000000; border-left: 2px solid #000000; width: 16.0938%;"
                    align="left" valign="top">
                     @foreach ($potongan as $potong)
                        <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">
                            {{ strtoupper($potong->keterangan) }}</div>
                    @endforeach
                </td>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-right: 2px solid #000000; width: 11.7188%;"
                    align="right" valign="top">
                     @foreach ($potongan as $potong)
                        <div style="font-family: arial; margin-bottom:5px; font-size: small; color: #000000;">
                             {{ number_indo($potong->nilai) }}</div>
                    @endforeach


                </td>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000; width: 16.25%;"
                    align="center" valign="middle"><span style="font-family: arial; color: #000000;"><b><i>GAJI
                                BERSIH</i></b></span></td>
            </tr>
            <tr>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; width: 16.0938%;"
                    align="left" valign="center"><span style="font-family: arial; color: #000000;"><strong>
                            <span style="font-size: small;">TOTAL</span> </strong></span></td>
                <td class="padding2"
                    style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-right: 2px solid #000000; width: 11.7188%;"
                    align="right" valign="center"><span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">{{ number_indo($payroll->gaji_pokok) }}</span>
                        </strong></span></td>
                <td class="padding2" style="border: 2px solid #000000; width: 32.8125%;" colspan="2"
                    align="right" valign="center"><span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">Rp. {{ number_indo($payroll->total_penambahan) }}</span>
                        </strong></span></td>
                <td class="padding2" style="border: 2px solid #000000; width: 23.125%;" colspan="2"
                    align="right" valign="center"><span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">Rp. {{ number_indo($payroll->total_potongan) }}</span>
                        </strong></span></td>
                <td class="padding2" style="border: 2px solid #000000; width: 16.25%;" align="right"
                    valign="center"><span style="font-family: arial; color: #000000;"><strong> <span
                                style="font-size: small;">Rp. {{ number_indo($payroll->total) }}</span>
                        </strong></span></td>
            </tr>
            <tr>
                <td class="padding2" style="width: 16.0938%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
                <td class="padding2" style="width: 11.7188%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
                <td class="padding2" style="width: 22.8906%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
                <td class="padding2" style="width: 9.92188%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
                <td class="padding2" style="width: 14.2969%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
                <td class="padding2" style="width: 8.82813%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
                <td class="padding2" style="width: 16.25%;" align="left" valign="middle"><span
                        style="color: #000000; font-family: arial;">&nbsp;</span></td>
            </tr>
            <tr>
                <td class="padding2" style="width: 100%;" colspan="7" align="left" valign="center"><span
                        style="font-family: arial; color: #000000;"><em> Terbilang: {{ terbilang($payroll->total) }}
                        </em></span></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
