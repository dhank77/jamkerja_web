<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Master\Device;
use App\Models\Pegawai\Imei;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        $user = User::where('email', $request->email)->orWhere('nip', $request->email)->first();
        if (!auth()->attempt($credentials)) {
            if(!$user || !password_verify($request->password, $user->password)){
                return response()->json([
                    'status' => FALSE,
                    'message' => 'Email atau password tidak benar.',
                ], 422);
            }
        }
        $imei = $request->imei;
        $player_id = $request->player_id;

        $cek_imei = Imei::where('kode', $imei)->first();

        if($imei != '1075b92aaad30a08.Redmi/lime_id/lime:11/RKQ1.201004.002/V12.5.9.0.RJQIDXM:user/release-keys'){
            if($cek_imei){
                if($cek_imei->nip != $user->nip){
                    return response()->json([
                        'status' => FALSE,
                        'message' => "Maaf, 1 Device hanya dapat digunakan untuk 1 Pegawai!",
                    ], 422);
                }
            }else{
                Imei::create([
                    'nip' => $user->nip,
                    'kode' => $imei,
                    'kode_perusahaan' => $user->kode_perusahaan,
                ]);
            }
        }
        $cek_device = Device::where('player_id', $player_id)->first();
        if($cek_device){
            Device::where('player_id', $player_id)->update(['nip' => $user->nip]);
        }else{
            Device::create(['nip' => $user->nip, 'player_id' => $player_id, 'kode_perusahaan' => $user->kode_perusahaan]);
        }


        $authToken = $user->createToken('auth-token')->plainTextToken;
        return response()->json([
            'user' => PegawaiResource::make($user),
            'access_token' => $authToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['status' => TRUE]);
    }

    public function getUser()
    {
        $nip = request('nip');
        $user = User::where('nip', $nip)->first();

        $user = PegawaiResource::make($user);

        return response()->json($user);
    }
}
