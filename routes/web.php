<?php

use Illuminate\Support\Facades\Route;

// Auth
Route::get('login', 'AuthController@index')->name('login');
Route::post('proses', 'AuthController@proses');
Route::post('logout', 'AuthController@logout')->name('logout');

Route::get('/', function () {
    return redirect()->route('login');
});
// Authenticated User With Checking Roles Middleware
Route::middleware(['auth', 'cekRole:admin,auditor,prodi'])->group(function () {

    // DASHBOARD
    Route::get('/dasbor', 'Auth\DashboardController@index')->name('dashboard');
});
