<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Pegawai\PegawaiResource;
use App\Models\Master\Device;
use App\Models\Pegawai\Imei;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function updateFoto()
    {
        $nip = request('nip');
        $image_64 = request('image');
        if ($image_64) {
            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = $nip . "/" . $nip . "-foto" . '.' . $extension;

            if(!in_array($extension, ['jpg', 'png', 'jpeg', 'gif'])){
                return response()->json(['status' => 'Error', 'messages' => 'File yang dimasukkan harus berupa gambar!']);
            }
            
            $cek = User::where('nip', $nip)->first();
            if ($cek && $cek->image) {
                Storage::delete($cek->image);
            }
            Storage::disk('public')->put("/$imageName", base64_decode($image));
            $cr = $cek->update(['image' => $imageName]);
            
            $user = User::where('nip', $nip)->first();
            
            if($cr){
                return response()->json(['status' => 'Success', 'messages' => 'Berhasil mengubah foto profil!', 'user' => PegawaiResource::make($user)]);
            }else{
                return response()->json(['status' => 'Error', 'messages' => 'Terjadi Kesalahan!']);
            }
        } else {
            return response()->json(['status' => 'Error', 'messages' => 'Anda harus melakukan foto terlebih dahulu!']);
        }
        
    }
}
