<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthOpd
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(role('opd') && role_only("owner") == false && role_only("admin") == false){
            $exp = explode("/", $request->path());
            if($exp[max(count($exp)-3, 0)] == "data"){
                $nip = $exp[count($exp)-1];
            }else{
                $nip = array_key_exists(2, $exp) ? $exp[2] : "";
            }


            if($nip != "" && strlen($nip) >= 36 && get_kode_skpd($nip) != auth()->user()->kepala_divisi_id){
                abort(403);
            }
        }

        
        if(role('admin') && role_only("owner") == false){
            $exp = explode("/", $request->path());
            if($exp[max(count($exp)-3, 0)] == "data"){
                $nip = $exp[count($exp)-1];
            }else{
                $nip = array_key_exists(2, $exp) ? $exp[2] : "";
            }

            if($nip != "" && strlen($nip) >= 36 && get_kode_perusahaan($nip) != auth()->user()->kode_perusahaan){
                abort(403);
            }

            if($exp[0] == 'master' && count($exp) >= 4 && is_integer($exp[3]) && validasi_master($exp)){
                abort(403);
            }
            if($exp[0] == 'pegawai' && count($exp) >= 5 && $exp[3] != 0 && validasi_data_pegawai($exp)){
                abort(403);
            }
        }

        return $next($request);
    }
}
