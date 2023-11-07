<?php

Route::get('element/{prodi}', 'ElementController@prodi')->name('element-prodi');
Route::get('tambah-element', 'ElementController@tambahElement')->name('tambah-element');
Route::get('tambah-element-parent', 'ElementController@tambahElementParent')->name('tambah-element-parent');
Route::get('element-list/{jenjang}', 'ElementController@listElement')->name('element-list');
Route::post('element-store', 'ElementController@store')->name('element-store');
Route::post('element-storeparent', 'ElementController@storeparent')->name('storeparent');

Route::get('element/unggah-berkas/{element}', 'ElementController@unggahBerkas');
Route::post('element/store-berkas', 'ElementController@storeBerkas');
Route::get('element/lihat-berkas/{element}', 'ElementController@lihatBerkas');

Route::get('element/syarat-akreditasi/{element}', 'ElementController@akreditas');
Route::put('element/put-akreditasi/{element}', 'ElementController@putAkreditas');

Route::get('element/syarat-unggul/{element}', 'ElementController@unggul');
Route::put('element/put-unggul/{element}', 'ElementController@putUnggul');

Route::get('element/syarat-baik/{element}', 'ElementController@baik');
Route::put('element/put-baik/{element}', 'ElementController@putBaik');

Route::delete('element/reset/{element}', 'ElementController@resetData');
Route::get('element/konfirmasi/{element}', 'ElementController@konfirHapus');
Route::delete('element/delete/{element}', 'ElementController@delete');

Route::get('element/detail/{element}', 'ElementController@detailElement');
Route::put('element/bobot/put/{element}', 'ElementController@putBobot');

Route::put('element/penilaian-auditor/{element}', 'ElementController@putPenilaianAuditor');
