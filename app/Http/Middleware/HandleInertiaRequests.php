<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $user = auth()->user() ?  auth()->user()->jabatan_akhir : '';
        if($user){
            $jabatan = array_key_exists('0', $user->toArray()) ? $user[0] : null;
        }else{
            $jabatan = null;
        }

        return array_merge(parent::share($request), [
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'auth' => [
                'user' => $request->user(),
                'role' => auth()->user() ? auth()->user()->getRoleNames() : '',
                'jabatan_akhir' => $jabatan,
            ],
            'perusahaan' => getPerusahaan(),
            'flash' => [
                'type' => $request->session()->get('type'),
                'messages' => $request->session()->get('messages'),
            ]
        ]);
    }
}
