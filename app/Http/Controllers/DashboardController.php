<?php

namespace App\Http\Controllers;

use App\Http\Resources\Dashboard\DashboardSakitResource;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Master\JamKerjaStatis;
use App\Models\Master\JkdJadwal;
use App\Models\Master\JkdMaster;
use App\Models\Master\Pendidikan;
use App\Models\Pegawai\DataPengajuanCuti;
use App\Models\Pegawai\DataPresensi;
use App\Models\Pegawai\DataVisit;
use App\Models\Pengajuan\PengajuanIjin;
use App\Models\Pengajuan\PengajuanIzin;
use App\Models\Pengajuan\PengajuanSakit;
use App\Models\Presensi\PresensiFree;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        // $data = compare_images('faces/006/006-face-20230131083935.jpg', 'presensi/101/kakak.jpg');
        // dd($data);
        // $data = train_image('111');
        // dd($data);
        // $data = recog_image('006', 'presensi/101/abi2.jpg');
        // if($data['status'] != 'success'){
        //     return response()->json(['status' => 'Error', 'messages' => 'Wajah tidak dikenali, silahkan coba lagi!']);
        // }
        // if($data['confidence'] < 50){
        //     $persen = round($data['confidence'], 2);
        //     return response()->json(['status' => 'Error', 'messages' => "Tingkat kemiripan hanya $persen%, silahkan coba lagi!"]);
        // }
        // dd('dikenali');
        // die;

        $role = role('opd');

        $qryPegawai = User::role('pegawai')
        ->when($role, function ($qr) {
            $user = auth()->user()->jabatan_akhir;
            $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
            $skpd = '';
            if ($jabatan) {
                $skpd = $jabatan->kode_skpd;
            }

            $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                $qt->on('riwayat_jabatan.nip', 'users.nip')
                    ->where('riwayat_jabatan.kode_skpd', $skpd)
                    ->where('riwayat_jabatan.is_akhir', 1);
            });
        })
        ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
        ->get();
        // Card
        $pegawai = $qryPegawai->count();

        $presensi = PresensiFree::whereDate('presensi_free.tanggal', date("Y-m-d"))
                    ->when($role, function ($qr) {
                        $user = auth()->user()->jabatan_akhir;
                        $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                        $skpd = '';
                        if ($jabatan) {
                            $skpd = $jabatan->kode_skpd;
                        }

                        $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                            $qt->on('riwayat_jabatan.nip', 'presensi_free.nip')
                                ->where('riwayat_jabatan.kode_skpd', $skpd)
                                ->where('riwayat_jabatan.is_akhir', 1);
                        });
                    })
                    ->where('presensi_free.kode_perusahaan', auth()->user()->kode_perusahaan)
                    ->count();
        $bulan = PresensiFree::whereMonth('presensi_free.tanggal', date("m"))
                ->when($role, function ($qr) {
                    $user = auth()->user()->jabatan_akhir;
                    $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                    $skpd = '';
                    if ($jabatan) {
                        $skpd = $jabatan->kode_skpd;
                    }

                    $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                        $qt->on('riwayat_jabatan.nip', 'presensi_free.nip')
                            ->where('riwayat_jabatan.kode_skpd', $skpd)
                            ->where('riwayat_jabatan.is_akhir', 1);
                    });
                })
                ->where('presensi_free.kode_perusahaan', auth()->user()->kode_perusahaan)
                ->count();
        $tahun = PresensiFree::whereYear('presensi_free.tanggal', date("Y"))
                ->when($role, function ($qr) {
                    $user = auth()->user()->jabatan_akhir;
                    $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                    $skpd = '';
                    if ($jabatan) {
                        $skpd = $jabatan->kode_skpd;
                    }

                    $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                        $qt->on('riwayat_jabatan.nip', 'presensi_free.nip')
                            ->where('riwayat_jabatan.kode_skpd', $skpd)
                            ->where('riwayat_jabatan.is_akhir', 1);
                    });
                })
                ->where('presensi_free.kode_perusahaan', auth()->user()->kode_perusahaan)
                ->count();

        // Grafik Jenis Kelamin
        $jenis_kelamin = [
            $qryPegawai->where("jenis_kelamin", 'perempuan')->count(),
            $qryPegawai->where("jenis_kelamin", 'laki-laki')->count(),
        ];

        // Grafik Pendidikan (ex agama)
        $agama = [];
        $label_agama = [];
        $dataAgama = Pendidikan::orderBy('kode_pendidikan')->get();
        foreach ($dataAgama as $value) {
            array_push($label_agama, ucfirst($value->nama));
            $jumlah = User::role('pegawai')
                            ->leftJoin('riwayat_pendidikan', 'riwayat_pendidikan.nip', 'users.nip')
                            ->when($role, function ($qr) {
                                $user = auth()->user()->jabatan_akhir;
                                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                                $skpd = '';
                                if ($jabatan) {
                                    $skpd = $jabatan->kode_skpd;
                                }

                                $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
                                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                                        ->where('riwayat_jabatan.kode_skpd', $skpd)
                                        ->where('riwayat_jabatan.is_akhir', 1);
                                });
                            })
                            ->where('riwayat_pendidikan.is_akhir', 1)
                            ->where('riwayat_pendidikan.kode_pendidikan', $value->kode_pendidikan)
                            ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                            ->count();
            array_push($agama, $jumlah);
        }

        $umur = [];
        $label_umur = [];
        $genUsia = getGenUsia();
        foreach ($genUsia as $gU) {
            array_push($label_umur, ucfirst($gU['nama']));
            array_push($umur, pegawai_berdasarkan_umur($gU));
        }

        // Grafik Golongan Darah
        $golongan = [];
        $label_golongan = [];
        // foreach (['A', 'B', 'AB', 'O'] as $value) {
        //     array_push($label_golongan, ucfirst($value));
        //     $jumlah = User::role('pegawai')->where("golongan_darah", $value)->when($role, function ($qr) {
        //         $user = auth()->user()->jabatan_akhir;
        //         $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
        //         $skpd = '';
        //         if ($jabatan) {
        //             $skpd = $jabatan->kode_skpd;
        //         }

        //         $qr->join('riwayat_jabatan', function ($qt) use ($skpd) {
        //             $qt->on('riwayat_jabatan.nip', 'users.nip')
        //                 ->where('riwayat_jabatan.kode_skpd', $skpd)
        //                 ->where('riwayat_jabatan.is_akhir', 1);
        //         });
        //     })->count();
        //     array_push($golongan, $jumlah);
        // }

        // Data Yang Akan Selesai Kontrak
        $selesai_kontrak = User::selectRaw('users.*, riwayat_jabatan.tanggal_tmt')
                                    ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
                                    ->where('riwayat_jabatan.is_akhir', 1)
                                    ->whereMonth('riwayat_jabatan.tanggal_tmt', date("m"))
                                    ->whereYear('riwayat_jabatan.tanggal_tmt', date("Y"))
                                    ->get();
        $selesai_kontrak = PegawaiResource::collection($selesai_kontrak);

        $pegawaiUltah = User::role("pegawai")
                        ->select("name", "tanggal_lahir")
                        ->ultah()
                        ->when($role, function ($qr) {
                            $user = auth()->user()->jabatan_akhir;
                            $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                            $skpd = '';
                            if($jabatan){
                                $skpd = $jabatan->kode_skpd; 
                            }
            
                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                    ->where('kode_skpd', $skpd)
                                    ->where('is_akhir', 1);
                            });
                        })
                        ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                        ->get();
        
        $jks = JamKerjaStatis::where("hari", date("w"))
                        ->where('jam_datang', '00:00')
                        ->where('jam_pulang', '00:00')
                        ->select("users.name")
                        ->leftJoin("jks_pegawai", "jks_pegawai.kode_jam_kerja", "jam_kerja_statis.kode_jam_kerja")
                        ->leftJoin("users", "users.nip", "jks_pegawai.nip")
                        ->when($role, function ($qr) {
                            $user = auth()->user()->jabatan_akhir;
                            $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                            $skpd = '';
                            if($jabatan){
                                $skpd = $jabatan->kode_skpd; 
                            }
            
                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                    ->where('kode_skpd', $skpd)
                                    ->where('is_akhir', 1);
                            });
                        })
                        ->where('jam_kerja_statis.kode_perusahaan', auth()->user()->kode_perusahaan);

        $pegawaiLibur = JkdJadwal::select("users.name")
                            ->leftJoin("users", "users.nip", "jkd_jadwal.nip")
                            ->where("tanggal", date("Y-m-d"))->where("kode_jkd", "L")
                            ->when($role, function ($qr) {
                                $user = auth()->user()->jabatan_akhir;
                                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                                $skpd = '';
                                if($jabatan){
                                    $skpd = $jabatan->kode_skpd; 
                                }
                
                                $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                                        ->where('kode_skpd', $skpd)
                                        ->where('is_akhir', 1);
                                });
                            })
                            ->where('jkd_jadwal.kode_perusahaan', auth()->user()->kode_perusahaan)
                            ->union($jks)
                            ->get();

        $sakitHariIni = PengajuanSakit::where("status", 1)
                                            ->whereDate("tanggal_mulai", "<=", date("Y-m-d"))
                                            ->whereDate("tanggal_selesai", ">=", date("Y-m-d"))
                                            ->leftJoin("users", "users.nip", "data_pengajuan_sakit.nip")
                                            ->select("users.name", "data_pengajuan_sakit.tanggal_mulai", "data_pengajuan_sakit.tanggal_selesai")
                                            ->when($role, function ($qr) {
                                                $user = auth()->user()->jabatan_akhir;
                                                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                                                $skpd = '';
                                                if($jabatan){
                                                    $skpd = $jabatan->kode_skpd; 
                                                }
                                
                                                $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                                                        ->where('kode_skpd', $skpd)
                                                        ->where('is_akhir', 1);
                                                });
                                            })
                                            ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                                            ->get();

        $cutiHariIni = DataPengajuanCuti::where("status", 1)
                                            ->with("cuti")
                                            ->whereDate("tanggal_mulai", "<=", date("Y-m-d"))
                                            ->whereDate("tanggal_selesai", ">=", date("Y-m-d"))
                                            ->leftJoin("users", "users.nip", "data_pengajuan_cuti.nip")
                                            ->when($role, function ($qr) {
                                                $user = auth()->user()->jabatan_akhir;
                                                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                                                $skpd = '';
                                                if($jabatan){
                                                    $skpd = $jabatan->kode_skpd; 
                                                }
                                
                                                $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                                                        ->where('kode_skpd', $skpd)
                                                        ->where('is_akhir', 1);
                                                });
                                            })
                                            ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                                            ->get();
                                            
        $izinHariIni = PengajuanIzin::where("status", 1)
                                            ->with("izin")
                                            ->whereDate("tanggal_mulai", "<=", date("Y-m-d"))
                                            ->whereDate("tanggal_selesai", ">=", date("Y-m-d"))
                                            ->leftJoin("users", "users.nip", "data_pengajuan_izin.nip")
                                            ->when($role, function ($qr) {
                                                $user = auth()->user()->jabatan_akhir;
                                                $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                                                $skpd = '';
                                                if($jabatan){
                                                    $skpd = $jabatan->kode_skpd; 
                                                }
                                
                                                $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                                    $qt->on('riwayat_jabatan.nip', 'users.nip')
                                                        ->where('kode_skpd', $skpd)
                                                        ->where('is_akhir', 1);
                                                });
                                            })
                                            ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                                            ->get();

        DashboardSakitResource::withoutWrapping();
        $sakitHariIni = DashboardSakitResource::collection($sakitHariIni);
        $cutiHariIni = DashboardSakitResource::collection($cutiHariIni);
        $izinHariIni = DashboardSakitResource::collection($izinHariIni);

        $ijinTerlambat = PengajuanIjin::where("status", 1)
                                        ->where("tanggal_mulai", "<=", date("Y-m-d"))
                                        ->where("tanggal_selesai", ">=", date("Y-m-d"))
                                        ->leftJoin("users", "users.nip", "data_pengajuan_ijin.nip")
                                        ->select("users.name", "keterangan")
                                        ->when($role, function ($qr) {
                                            $user = auth()->user()->jabatan_akhir;
                                            $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
                                            $skpd = '';
                                            if($jabatan){
                                                $skpd = $jabatan->kode_skpd; 
                                            }
                            
                                            $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                                                $qt->on('riwayat_jabatan.nip', 'users.nip')
                                                    ->where('kode_skpd', $skpd)
                                                    ->where('is_akhir', 1);
                                            });
                                        })
                                        ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                                        ->get();

        $kunjungan = DataVisit::selectRaw("data_visit.id as id, users.name as nama, users.nip as nip, data_visit.tanggal, data_visit.judul, data_visit.keterangan, data_visit.kordinat, data_visit.lokasi, data_visit.foto, data_visit.created_at")
                ->leftJoin('users', 'users.nip', 'data_visit.nip')
                ->when($role, function ($qr) {
                    $skpd = auth()->user()->kepala_divisi_id;
            
                    $qr->join('riwayat_jabatan', function ($qt) use($skpd) {
                        $qt->on('riwayat_jabatan.nip', 'users.nip')
                            ->where('riwayat_jabatan.kode_skpd', $skpd)
                            ->whereNull('riwayat_jabatan.deleted_at')
                            ->where('riwayat_jabatan.is_akhir', 1);
                    });
                })
                ->whereDate('data_visit.tanggal', date('Y-m-d'))
                ->whereNull('users.deleted_at')
                ->where('users.kode_perusahaan', auth()->user()->kode_perusahaan)
                ->get();

       $presensi_summary = kehadiran_free_summary(date('m'), date('Y'));

        return inertia("Dashboard", compact('pegawai', 'presensi', 'bulan', 'tahun', 'jenis_kelamin', 'agama', 'label_agama', 'umur', 'label_umur', 'selesai_kontrak', "pegawaiUltah", "pegawaiLibur", "sakitHariIni", "ijinTerlambat", "cutiHariIni", "izinHariIni", 'presensi_summary', 'kunjungan'));
    }
}
