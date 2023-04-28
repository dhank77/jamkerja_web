<!DOCTYPE html>
<html>

<head>
    <title>Biodata - {{ $pegawai->gelar_depan . ' ' . $pegawai->name . ' ' . $pegawai->gelar_belakang }}</title>
    <style>
        td {
            padding: 5px
        }
    </style>
</head>

<body>
    <div style="padding-top: -40px;">
        <table style="border-collapse: collapse; width: 100%;" border="0">
            @php
                $perusahaan = getPerusahaan();
            @endphp
            <tbody>
                <tr>
                    <td style="width: 13.5027%; border-style: hidden;">
                        <span style="font-family: arial;">
                            @if ($perusahaan->logo != '')
                                <img style="float: left; margin-top:10px; margin-left:20px"
                                    src="{{ asset($perusahaan->logo) }}" alt="" height="50" />
                            @endif
                        </span>
                    </td>
                    <td style="width: 70.7887%; text-align: center; border-style: hidden;">
                        <p> <strong>
                                <span
                                    style="color: #000000; font-family: arial; font-size: 20pt;">{{ strtoupper($perusahaan->nama) }}</span></strong><br />
                            <strong>
                                <span
                                    style="color: #000000; font-family: arial;">{{ $perusahaan->alamat }}</span></strong>
                            <br />
                            <span style="color: #000000; font-family: arial;">{{ $perusahaan->kontak }}</span>
                        </p>
                    </td>
                    <td style="width: 10%; border-style: hidden;">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <div style="border: 1px solid black;"></div>
        <hr /><br />
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td style="width: 100%; background-color: lightskyblue; border-style: hidden; text-align: center;">
                        <span style="font-family: arial; font-size: 18pt; color: #000000;"><strong>B I O D A T
                                A</strong></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <p><span style="font-family: arial; color: #000000;"><strong>I. DATA PRIBADI</strong></span></p>
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td rowspan="10" style="width: 2%; vertical-align: top; border-style: hidden;"></td>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">a.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Nomor Pegawai</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">{{ $pegawai->nip }}</td>
                    <td style="width: 22.0054%; vertical-align: top; border-style: hidden;" rowspan="7">
                        {!! $pegawai->image != null && file_exists('storage/' . $pegawai->image)
                            ? '<img style="float: right;" src="' .
                                asset('storage/' . $pegawai->image) .
                                '" alt="" width="150" height="191" /></td>'
                            : '<img style="float: right;" src="' .
                                asset("no-image.png") .
                                '" alt="" width="150" height="191" /></td>' !!}

                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">b.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Nama</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $pegawai->gelar_depan . ' ' . $pegawai->name . ' ' . $pegawai->gelar_belakang }}</td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">c.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Tempat dan Tgl Lahir</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $pegawai->tempat_lahir . ', ' . tanggal_indo($pegawai->tanggal_lahir) }}</td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">d.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Agama</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ ucfirst($pegawai->kode_agama) }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">e.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Suku Bangsa</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $pegawai?->suku?->nama }}
                    </td>
                </tr>
                @php
                    $jabatan = array_key_exists('0', $pegawai->jabatan_akhir->toArray()) ? $pegawai->jabatan_akhir[0] : null;
                    $skpd = $jabatan?->skpd?->nama;
                    $nama_jabatan = $jabatan?->tingkat?->nama;
                    $pendidikan = array_key_exists('0', $pegawai->pendidikan_akhir->toArray()) ? $pegawai->pendidikan_akhir[0] : null;
                    $tingkat_pendidikan = $pendidikan?->pendidikan?->nama;
                    $jurusan_pendidikan = $pendidikan?->jurusan?->nama;
                @endphp
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">f.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Pendidikan Terakhir</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $tingkat_pendidikan }} - {{ $jurusan_pendidikan }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">g.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Jabatan Sekarang</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $nama_jabatan }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">h.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Divisi Kerja</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $skpd }}
                    </td>
                    <td style="width: 22.0054%; vertical-align: top; border-style: hidden;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">i.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">Alamat</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">
                        {{ $pegawai->alamat }}
                    </td>
                    <td style="width: 22.0054%; vertical-align: top; border-style: hidden;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width: 5.42781%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">j.</span></td>
                    <td style="width: 22.9412%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">No Telepon</span></td>
                    <td style="width: 3.28875%; vertical-align: top; border-style: hidden;"><span
                            style="color: #000000; font-family: arial;">:</span></td>
                    <td style="width: 46.3368%; vertical-align: top; border-style: hidden;">{{ $pegawai->no_hp }}</td>
                    <td style="width: 22.0054%; vertical-align: top; border-style: hidden;">&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p>
                            <span style="font-family: arial; color: #000000;">
                                <strong>II. RIWAYAT JABATAN<br /></strong>
                            </span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                <tr style="margin-bottom:20px;">
                    <td style="width: 5.82888%;">
                        <span style="font-family: arial; color: #000000;"><strong>No.</strong></span>
                    </td>
                    {{-- <td style="width: 5%; ">
                        <span style="font-family: arial; color: #000000;"><strong>Jenis Jabatan</strong></span>
                    </td> --}}
                    <td style="width: 30%; text-align:center">
                        <span style="font-family: arial; color: #000000;"><strong>Nama Jabatan</strong></span>
                    </td>
                    <td style="width: 35%; text-align:center;">
                        <span style="font-family: arial; color: #000000;"><strong>Divisi</strong></span>
                    </td>
                    <td style="width: 15%;">
                        <span style="font-family: arial; color: #000000;"><strong>TMT Jabatan</strong></span>
                    </td>
                    <td style="width: 15%;">
                        <span style="font-family: arial; color: #000000;"><strong>SK Jabatan</strong></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                @php
                    $riwayat_jabatan = $pegawai->riwayat_jabatan;
                @endphp
                @foreach ($riwayat_jabatan as $key => $value)
                    <tr role="row" class="odd">
                        <td style="width: 5.82888%;">{{ $key + 1 }}.</td>
                        {{-- <td style="width: 5%">{{ jenis_jabatan($value->jenis_jabatan) }}</td> --}}
                        <td style="width: 30%; text-align:center">{{ $value?->tingkat?->nama }}</td>
                        <td style="width: 30%; text-align:center">{{ $value?->skpd?->nama }}</td>
                        <td style="width: 20%;">{{ tanggal_indo($value->tanggal_tmt) }}</td>
                        <td style="width: 20%;">{{ tanggal_indo($value->tanggal_sk) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p>
                            <span style="font-family: arial; color: #000000;">
                                <strong>III. RIWAYAT PENDIDIKAN<br /></strong>
                            </span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                <tr style="margin-bottom:20px;">
                    <td style="width: 5.82888%;">
                        <span style="font-family: arial; color: #000000;"><strong>No.</strong></span>
                    </td>
                    <td style="width: 10%; text-align:center">
                        <span style="font-family: arial; color: #000000;"><strong>Tingkat</strong></span>
                    </td>
                    <td style="width: 35%; text-align:center;">
                        <span style="font-family: arial; color: #000000;"><strong>Jurusan</strong></span>
                    </td>
                    <td style="width: 35%;">
                        <span style="font-family: arial; color: #000000;"><strong>Nama Sekolah</strong></span>
                    </td>
                    <td style="width: 15%;">
                        <span style="font-family: arial; color: #000000;"><strong>Tanggal Lulus</strong></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                @php
                    $pendidikan = $pegawai->riwayat_pendidikan;
                @endphp
                @foreach ($pendidikan as $key => $value)
                    <tr role="row" class="odd">
                        <td style="width: 5.82888%;">{{ $key + 1 }}.</td>
                        <td style="width: 10%; text-align:center">{{ $value?->pendidikan?->nama }}</td>
                        <td style="width: 30%; text-align:center">{{ $value?->jurusan?->nama }}</td>
                        <td style="width: 30%;">{{ $value->nama_sekolah }}</td>
                        <td style="width: 20%;">{{ tanggal_indo($value->tanggal_lulus) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p>
                            <span style="font-family: arial; color: #000000;">
                                <strong>IV. RIWAYAT PELATIHAN & KURSUS<br /></strong>
                            </span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                <tr style="margin-bottom:20px;">
                    <td style="width: 5.82888%;">
                        <span style="font-family: arial; color: #000000;"><strong>No.</strong></span>
                    </td>
                    <td style="width: 30%; text-align:center">
                        <span style="font-family: arial; color: #000000;"><strong>Nama Kursus</strong></span>
                    </td>
                    <td style="width: 35%; text-align:center;">
                        <span style="font-family: arial; color: #000000;"><strong>Tempat</strong></span>
                    </td>
                    <td style="width: 35%;">
                        <span style="font-family: arial; color: #000000;"><strong>Pelaksana</strong></span>
                    </td>
                    <td style="width: 15%;">
                        <span style="font-family: arial; color: #000000;"><strong>Tanggal Sertifikat</strong></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                @php
                    $kursus = $pegawai->riwayat_kursus;
                @endphp
                @foreach ($kursus as $key => $value)
                    <tr role="row" class="odd">
                        <td style="width: 5.82888%;">{{ $key + 1 }}.</td>
                        <td style="width: 30%; text-align:center">{{ $value?->kursus?->nama }}</td>
                        <td style="width: 30%; text-align:center">{{ $value->tempat }}</td>
                        <td style="width: 30%;">{{ $value->pelaksana }}</td>
                        <td style="width: 20%;">{{ tanggal_indo($value->tanggal_sertifikat) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p>
                            <span style="font-family: arial; color: #000000;">
                                <strong>V. RIWAYAT PENGHARGAAN<br /></strong>
                            </span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                <tr style="margin-bottom:20px;">
                    <td style="width: 5.82888%;">
                        <span style="font-family: arial; color: #000000;"><strong>No.</strong></span>
                    </td>
                    <td style="width: 30%; text-align:center">
                        <span style="font-family: arial; color: #000000;"><strong>Nama Penghargaan</strong></span>
                    </td>
                    <td style="width: 35%; text-align:center;">
                        <span style="font-family: arial; color: #000000;"><strong>Oleh</strong></span>
                    </td>
                    <td style="width: 35%;">
                        <span style="font-family: arial; color: #000000;"><strong>Nomor SK</strong></span>
                    </td>
                    <td style="width: 15%;">
                        <span style="font-family: arial; color: #000000;"><strong>Tanggal SK</strong></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                @php
                    $penghargaan = $pegawai->riwayat_penghargaan;
                @endphp
                @foreach ($penghargaan as $key => $value)
                    <tr role="row" class="odd">
                        <td style="width: 5.82888%;">{{ $key + 1 }}.</td>
                        <td style="width: 30%; text-align:center">{{ $value?->penghargaan?->nama }}</td>
                        <td style="width: 30%; text-align:center">{{ $value->oleh }}</td>
                        <td style="width: 30%;">{{ $value->nomor_sk }}</td>
                        <td style="width: 20%;">{{ tanggal_indo($value->tanggal_sk) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <table style="border-collapse: collapse; width: 100%;" border="0">
            <tbody>
                <tr>
                    <td colspan="6">
                        <p>
                            <span style="font-family: arial; color: #000000;">
                                <strong>VI. DATA KELUARGA<br /></strong>
                            </span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                <tr style="margin-bottom:20px;">
                    <td style="width: 5.82888%;">
                        <span style="font-family: arial; color: #000000;"><strong>No.</strong></span>
                    </td>
                    <td style="width: 10%; text-align:center">
                        <span style="font-family: arial; color: #000000;"><strong>Status</strong></span>
                    </td>
                    <td style="width: 35%; text-align:center;">
                        <span style="font-family: arial; color: #000000;"><strong>Nama</strong></span>
                    </td>
                    <td style="width: 30%;">
                        <span style="font-family: arial; color: #000000;"><strong>Tempat, Tanggal Lahir</strong></span>
                    </td>
                    <td style="width: 10%;">
                        <span style="font-family: arial; color: #000000;"><strong>No. Telepon</strong></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div style="border: 0.5px solid black;"></div>
                    </td>
                </tr>
                @php
                    $keluarga = $pegawai->keluarga;
                @endphp
                @foreach ($keluarga as $key => $value)
                    <tr role="row" class="odd">
                        <td style="width: 5.82888%;">{{ $key + 1 }}.</td>
                        @if ($value->status == 'suami/istri')
                            @if ($pegawai->jenis_kelamin == 'laki-laki')
                                <td style="width: 10%; text-align:center">Istri</td>
                            @else
                                <td style="width: 10%; text-align:center">Suami</td>
                            @endif
                        @else
                        <td style="width: 30%; text-align:center">{{ ucfirst($value->status) }}</td>
                        @endif
                        <td style="width: 30%; text-align:center">{{ ucwords($value->nama) }}</td>
                        <td style="width: 30%;">
                            {{ $value->tempat_lahir . ', ' . tanggal_indo($value->tanggal_lahir) }}</td>
                        <td style="width: 10%;">{{ $value->nomor_telepon }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <p>&nbsp;</p>
    <table style="border-collapse: collapse; width: 100%;" border="0">
        <tbody>
            <tr>
                <td style="width: 50%; border-style: hidden;">&nbsp;</td>
                <td style="width: 50%; text-align: center; border-style: hidden;"><span
                        style="color: #000000;">................,
                        {{ tanggal_indo(date('Y-m-d')) }}</span><br /><br /><span
                        style="color: #000000;">DIREKTUR</span>
                    <br />
                    <span style="color: #000000;">{{ strtoupper($perusahaan->nama) }}</span><br /><br /><br /><br />
                    <span style="text-decoration: underline;">{{ strtoupper($perusahaan->direktur) }}<span
                            style="color: #000000; text-decoration: underline;"></span></span><br /><span
                        style="color: #000000;"></span><br /><span
                        style="color: #000000;">{{ strtoupper($perusahaan->nomor) }}</span>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
