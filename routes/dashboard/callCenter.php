<?php

use App\Http\Controllers\Dashboard\CallCenter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    Route::group(['prefix' => 'callCenter', 'middleware' => 'auth:call-center'], function () {
        Route::get('dashboard', [CallCenter\CallCenterDashboardController::class, 'index'])->name('callCenter.dashboard');
    });
});
