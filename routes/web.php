<?php

use Illuminate\Support\Facades\Route;

//Auth
Route::get('login', 'AuthController@index')->name('login');
Route::post('proses', 'AuthController@proses');
Route::post('logout', 'AuthController@logout')->name('logout');

//HOME
// Route::get('/', 'HomeController@index')->name('home');
Route::get('/', function () {
    return redirect()->route('login');
});
// Halaman Statis
Route::get('/profil/{slug}', 'StaticPageController@show')->name('home.static-page');

Route::get('tabel/{prodi:kode}', 'HomeController@tabel');
Route::get('tabel/berkas/{element}', 'HomeController@berkas');
Route::get('tabel/view/{berkas}', 'HomeController@view');

Route::get('single-search', 'HomeController@singleSearch')->name('singleSearch');
Route::post('single-search/hasil', 'HomeController@hasilsingleSearch');

Route::get('multiple-search', 'HomeController@multiSearch')->name('multipleSearch');
Route::post('multi-search/hasil', 'HomeController@hasilmultiSearch');

Route::get('search-kriteria/{lv}/{id}', 'KriteriaController@search');

Route::get('diagram', 'HomeController@diagram')->name('diagram');
Route::get('diagram/login', function () {
    return redirect()->route('login');
});
Route::get('diagram/{prodi:kode}', 'HomeController@radarDiagram');

Route::middleware(['auth', 'cekRole:Admin,Prodi,Auditor'])->group(function () {

    // DASHBOARD
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
});
