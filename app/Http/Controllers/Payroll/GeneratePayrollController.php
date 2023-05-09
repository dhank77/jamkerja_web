<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\Controller;
use App\Http\Resources\Payroll\DataPayrollResource;
use App\Http\Resources\Payroll\GeneratePayrollResource;
use App\Jobs\ProcessGeneratePayroll;
use App\Models\Payroll\DataPayroll;
use App\Models\Payroll\GeneratePayroll;
use App\Models\Payroll\PayrollKurang;
use App\Models\Payroll\PayrollTambah;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use PDF;

class GeneratePayrollController extends Controller
{
    public function index()
    {
        $search = request('s');
        $limit = request('limit') ?? 10;

        $payroll = GeneratePayroll::when($search, function($qr, $search){
                        $qr->where('kode_payroll', 'LIKE', "%$search%");
                    })
                    ->latest()
                    ->where('kode_perusahaan', kp())
                    ->paginate($limit);

        $payroll->appends(request()->all());

        $payroll = GeneratePayrollResource::collection($payroll);

        return inertia('Payroll/Generate/Index', compact('payroll'));
    }

    public function add()
    {
        return inertia('Payroll/Generate/Add');
    }

    public function store()
    {
        $bulan = request('bulan') ?? date("m");
        $tahun = request('tahun') ?? date("Y");
        $kode_skpd = request('kode_skpd');
        $kode_payroll = date("YmdHis") . generateRandomString();

        $whereNotIn = [];

        $qry = GeneratePayroll::where('bulan', $bulan)->where('tahun', $tahun);

        $cek = with(clone $qry)->whereNull('kode_skpd')->where('is_aktif', 1)->first();
        if ($cek) {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, Payroll Telah digenerate sebelumnya!"
            ]);
        }

        if ($kode_skpd) {
            $skpd = with(clone $qry)->where('kode_skpd', $kode_skpd)->where('is_aktif', 1)->first();
            if ($skpd) {
                return redirect()->back()->with([
                    'type' => 'error',
                    'messages' => "Gagal, Payroll Telah digenerate sebelumnya!"
                ]);
            }
        }

        $update = with(clone $qry)->first();

        if ($update) {
            $kode_payroll = $update->kode_payroll;
            $whereNotIn = $qry->where('is_aktif', 1)->get()->pluck('kode_skpd')->toArray();
        }

        GeneratePayroll::updateOrCreate(
            [
                'kode_perusahaan' => kp(),
                'kode_payroll' => $kode_payroll,
            ],
            [
                'bulan' => $bulan,
                'tahun' => $tahun,
                'kode_skpd' => $kode_skpd,
            ]
        );

        $pegawai = User::role('pegawai')
                        ->when($kode_skpd, function ($qr, $kode_skpd) {
                            $qr->where('riwayat_jabatan.kode_skpd', $kode_skpd);
                        })
                        ->leftJoin('riwayat_jabatan', 'riwayat_jabatan.nip', 'users.nip')
                        ->where('riwayat_jabatan.is_akhir', 1)
                        ->whereNotIn('riwayat_jabatan.kode_skpd', $whereNotIn)
                        ->select('users.nip', 'users.no_hp')
                        ->where('users.kode_perusahaan', kp())
                        ->get();

        foreach ($pegawai as $peg) {
            $jabatan = array_key_exists('0', $peg->jabatan_akhir->toArray()) ? $peg->jabatan_akhir[0] : null;
            generate_payroll_nip($peg->nip, $peg->no_hp, $jabatan, $kode_payroll, $bulan, $tahun);
            // dispatch(new ProcessGeneratePayroll($peg->nip, $peg->no_hp, $jabatan, $kode_payroll, $bulan, $tahun));
        }

        return redirect()->back()->with([
            'type' => 'success',
            'messages' => "Berhasil, Pemberitahuan melalui Whatsapp jika payroll berhasil digenerate!"
        ]);
    }

    public function regenerate(GeneratePayroll $generate)
    {
        $nip = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->where('is_aktif', 0)->pluck('nip')->toArray();

        $pegawai = User::role('pegawai')->whereIn('nip', $nip)->get();
        foreach ($pegawai as $peg) {
            $jabatan = array_key_exists('0', $peg->jabatan_akhir->toArray()) ? $peg->jabatan_akhir[0] : null;
            dispatch(new ProcessGeneratePayroll($peg->nip, $peg->no_hp, $jabatan, $generate->kode_payroll, $generate->bulan, $generate->tahun));
        }

        return redirect()->back()->with([
            'type' => 'success',
            'messages' => "Berhasil, Pemberitahuan melalui Whatsapp jika payroll berhasil digenerate!"
        ]);
    }

    public function delete(GeneratePayroll $generate)
    {
        PayrollTambah::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->delete();
        PayrollKurang::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->delete();
        DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->delete();

        $cr = $generate->delete();
        if ($cr) {
            return redirect(route('payroll.generate.index'))->with([
                'type' => 'success',
                'messages' => "Berhasil, dihapus!"
            ]);
        } else {
            return redirect(route('payroll.generate.index'))->with([
                'type' => 'error',
                'messages' => "Gagal, dihapus!"
            ]);
        }
    }

    public function detail(GeneratePayroll $generate)
    {

        $search = request('s');
        $limit = request('limit') ?? 10;

        $payroll = DataPayroll::when($search, function($qr, $search){
                        $qr->where('kode_payroll', 'LIKE', "%$search%");
                    })
                    ->latest()
                    ->where('kode_perusahaan', kp())
                    ->paginate($limit);

        $payroll->appends(request()->all());

        $payroll = DataPayrollResource::collection($payroll);
        GeneratePayrollResource::withoutWrapping();
        $generate = GeneratePayrollResource::make($generate);

        return inertia('Payroll/Generate/Detail', compact('payroll', 'generate'));
    }

    public function approved(GeneratePayroll $generate, $payroll = null)
    {
        if($payroll == null){
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->update(['is_aktif', 1]);
            $generate->update(['is_aktif' => 1]);
        }else{
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll->where('kode_perusahaan', kp()))->where('id', $payroll)->update(['is_aktif' => 1]);
            $count = DataPayroll::where('kode_payroll', $generate->kode_payroll->where('kode_perusahaan', kp()))->where('is_aktif', 0)->count();
            if($count == 0){
                $generate->update(['is_aktif' => 1]);
            }
        }

        if ($cr) {
            return redirect()->back()->with([
                'type' => 'success',
                'messages' => "Berhasil, disetujui!"
            ]);
        } else {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, disetujui!"
            ]);
        }
    }

    public function rejected(GeneratePayroll $generate, $payroll = null)
    {
        if($payroll == null){
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->update(['is_aktif', 0]);
        }else{
            $cr = DataPayroll::where('kode_payroll', $generate->kode_payroll)->where('kode_perusahaan', kp())->where('id', $payroll)->update(['is_aktif' => 0]);
        }
        $generate->update(['is_aktif' => 0]);

        if ($cr) {
            return redirect()->back()->with([
                'type' => 'success',
                'messages' => "Berhasil, dibatalkan!"
            ]);
        } else {
            return redirect()->back()->with([
                'type' => 'error',
                'messages' => "Gagal, dibatalkan!"
            ]);
        }
    }

    public function slip()
    {
        $download = request('download') ?? 0;
        $nip = request('nip');
        $kode_payroll = request('kode_payroll');

        $payroll = DataPayroll::where('nip', $nip)->where('kode_payroll', $kode_payroll)->where('kode_perusahaan', kp())->first();
        $penambahan = PayrollTambah::where('nip', $nip)->where('kode_payroll', $kode_payroll)->where('kode_perusahaan', kp())->get();
        $potongan = PayrollKurang::where('nip', $nip)->where('kode_payroll', $kode_payroll)->where('kode_perusahaan', kp())->get();
        

        $pdf = PDF::loadView('laporan.slipgaji.index', compact('payroll', 'penambahan', 'potongan'))->setPaper('a4', 'landscape');

        if($download == 1){
            Storage::put("pdf/$nip/slipgaji$payroll->bulan-$payroll->tahun.pdf", $pdf->output());
            // return redirect("storage/pdf/$nip/slipgaji$payroll->bulan-$payroll->tahun.pdf");
            return redirect("https://docs.google.com/viewer?url=" . asset("storage/pdf/$nip/slipgaji$payroll->bulan-$payroll->tahun.pdf"));
        }else{
            return $pdf->stream();
        }
    }

    public function slip_frame()
    {
        $nip = request('nip');
        $kode_payroll = request('kode_payroll');
        
        return view("slip_frame", compact("nip", "kode_payroll"));
    }
}
