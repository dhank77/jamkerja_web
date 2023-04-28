<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UbahPassword extends Controller
{
    
    public function index()
    {
        return inertia('UbahPassword');
    }

    public function update()
    {
        $password = request('password');
        $password_baru = request('password_baru');

        $cek = Hash::check($password, auth()->user()->password);
        if($cek){
            $pass = password_hash($password_baru, PASSWORD_BCRYPT);
            $up = auth()->user()->update(['password' => $pass]);
        }else{
            $up = null;
        }

        if($up){
            return redirect(route('password.index'))->with([
                'type' => 'success',
                'messages' => 'Berhasil!'
            ]);
        }else{
            return redirect(route('password.index'))->with([
                'type' => 'error',
                'messages' => 'Gagal!'
            ]);
        }
    }
}
