<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CronJobController;
use App\Http\Controllers\Api\CutiApiController;
use App\Http\Controllers\Api\IjinApiController;
use App\Http\Controllers\Api\IzinApiController;
use App\Http\Controllers\Api\LemburApiController;
use App\Http\Controllers\Api\PayrollApiController;
use App\Http\Controllers\Api\PengumumanApiController;
use App\Http\Controllers\Api\PerusahaanApiController;
use App\Http\Controllers\Api\PresensiApiController;
use App\Http\Controllers\Api\ReimbursementApiController;
use App\Http\Controllers\Api\SakitApiController;
use App\Http\Controllers\Api\ShiftApiController;
use App\Http\Controllers\Api\VisitApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::prefix('cron')->group(function(){
    Route::get('istirahat', [CronJobController::class, 'istirahat']);
});


Route::middleware('auth:sanctum')->group(function(){

    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('getUser', [AuthController::class, 'getUser']);
    Route::post('updateFoto', [AuthController::class, 'updateFoto']);


    Route::controller(PerusahaanApiController::class)
        ->prefix('perusahaan')
        ->name('perusahaan.')
        ->group(function(){
            Route::get('', 'index');
        });

    Route::controller(PresensiApiController::class)
        ->prefix('presensi')
        ->name('presensi.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('rekap_bulan', 'rekap_bulan');
            Route::post('store', 'store');
            Route::post('store_free', 'store_free');
            Route::post('store_free_face', 'store_free_face');
            Route::get('lists', 'lists');
            Route::get('shift', 'shift');
            Route::get('master_jam_kerja', 'master_jam_kerja');
            Route::get('jam_kerja', 'jam_kerja');
            Route::get('jam_kerja_statis', 'jam_kerja_statis');
            Route::get('jam_kerja_calender', 'jam_kerja_calender');
            Route::get('lokasi', 'lokasi');
            Route::get('laporan', 'laporan');
            Route::get('laporan_free', 'laporan_free');
        });

    Route::controller(VisitApiController::class)
        ->prefix('visit')
        ->name('visit.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('lokasi', 'lokasi');
            Route::post('store', 'store');
            Route::post('store-new', 'store_new');
        });

    Route::controller(PengumumanApiController::class)
        ->prefix('pengumuman')
        ->name('pengumuman.')
        ->group(function(){
            Route::get('', 'index');
            Route::get('detail/{pengumuman}', 'detail');
            Route::get('count', 'count');
        });

    Route::controller(PayrollApiController::class)
        ->prefix('payroll')
        ->name('payroll.')
        ->group(function(){
            Route::get('', 'index');
        });

    Route::prefix('pengajuan')
        ->group(function () {

        Route::controller(CutiApiController::class)
            ->prefix('cuti')
            ->group(function () {
                Route::get('',  'index');
                Route::get('tahunan',  'tahunan');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });

        Route::controller(SakitApiController::class)
            ->prefix('sakit')
            ->group(function () {
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });

        Route::controller(IzinApiController::class)
            ->prefix('izin')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });

        Route::controller(IjinApiController::class)
            ->prefix('ijin')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });

        Route::controller(LemburApiController::class)
            ->prefix('lembur')
            ->group(function () {
                Route::get('lists', 'lists');
                Route::get('getHariIni', 'getHariIni');
                Route::post('store',  'store');
                Route::post('presensi',  'presensi');
                Route::get('detail',  'detail');
            });

        Route::controller(ReimbursementApiController::class)
            ->prefix('reimbursement')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });
        Route::controller(ShiftApiController::class)
            ->prefix('shift')
            ->group(function () {
                Route::get('',  'index');
                Route::get('lists', 'lists');
                Route::post('store', 'store');
                Route::get('detail',  'detail');
            });
    });

});
