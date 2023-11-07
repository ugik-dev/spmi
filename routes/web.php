<?php

use Illuminate\Support\Facades\Route;

//Auth
Route::get('login', 'AuthController@index')->name('login');
Route::post('proses', 'AuthController@proses');
Route::post('logout', 'AuthController@logout')->name('logout');

//HOME
Route::get('/', 'HomeController@index')->name('home');

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

    /**
     * 1.Static Page (halaman statis/profil) yang harus login dlu
     * 2.Gallery
     * 3.Prodi
     * 4.L1 - L4
     * 5.Indikator
     * 6.Element
     */

    $filesToRequire = [
        'auth_static-page.php',
        'gallery.php',
        'prodi.php',
        'l1-4.php',
        'indikator.php',
        'element.php'
    ];

    foreach ($filesToRequire as $file) {
        require __DIR__ . '/' . $file;
    }

    //DATA BERKAS
    Route::get('berkas/cari', 'BerkasController@cari')->name('berkas');
    Route::post('berkas/hasil', 'BerkasController@hasil');
    Route::get('berkas/{berkas}', 'BerkasController@detail');

    Route::delete('berkas/hapus/{berkas}', 'BerkasController@hapus');
    Route::get('berkas/edit/{berkas}', 'BerkasController@edit');
    Route::put('berkas/put/{berkas}', 'BerkasController@put');

    // Pengaturan
    Route::get('jenjang-pendidkan', 'PengaturanController@jenjang')->name('jenjang');
    Route::post('jenjang-pendidikan/post', 'PengaturanController@jenjangPost');
    Route::delete('jenjang-pendidikan/hapus/{jenjang}', 'PengaturanController@jenjangDelete');
    Route::put('jenjang-pendidikan/put/{jenjang}', 'PengaturanController@jenjangPut');

    Route::get('program-studi', 'PengaturanController@prodi')->name('prodi');
    Route::post('program-studi/post', 'PengaturanController@prodiPost');
    Route::delete('program-studi/hapus/{prodi}', 'PengaturanController@prodiDelete');
    Route::put('program-studi/put/{prodi}', 'PengaturanController@prodiPut');

    Route::get('edit-profil-fakultas/{fakultas}', 'PengaturanController@fakultasProfil')->name('edit-profil-fakultas');
    Route::get('fakultas', 'PengaturanController@fakultas')->name('fakultas');
    Route::post('fakultas/post', 'PengaturanController@fakultasPost');
    Route::delete('fakultas/hapus/{fakultas}', 'PengaturanController@fakultasDelete');
    Route::put('fakultas/put/{fakultas}', 'PengaturanController@fakultasPut');

    // DATA USER
    Route::get('users', 'AdminController@index')->name('users');
    Route::get('users/tambah/', 'AdminController@tambahUser')->name('tambah');
    Route::post('users/store', 'AdminController@store');
    Route::delete('users/hapus/{user}', 'AdminController@hapus');
    Route::get('users/edit/{user}', 'AdminController@edit');
    Route::put('users/put/{user}', 'AdminController@put');

    // DATA TARGET PENCAPAIAN
    Route::get('target', 'TargetController@index')->name('target');
    Route::get('target/{prodi:kode}', 'TargetController@detail');
    Route::get('target/create-target/{prodi:kode}', 'TargetController@createTarget');
    Route::put('target/update/{target}', 'TargetController@update');

    // DATA MAHASISWA
    Route::get('data/mahasiswa/{prodi:kode}', 'MahasiswaController@index');
    Route::get('data/mahasiswa/tambah/{prodi:kode}', 'MahasiswaController@tambah');
    Route::post('data/mahasiswa/store', 'MahasiswaController@store');

    // Show image
    Route::get('/show-image/{filename}', function ($filename) {
        $path = storage_path('app/prodi/' . $filename);
        if (file_exists($path)) {
            return response()->file($path);
        } else {
            abort(404);
        }
    })->name('showimage');
});

//Dropdown Ajax [Buat Element, Cari Berkas]
require __DIR__ . '/dropdown.php';
