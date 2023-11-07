<?php
Route::get('prodi/{prodi}', 'ProdiController@index')->name("prodis");
Route::get('prodi/profil/{prodi:kode}', 'ProdiController@profil')->name('profil-prodi');
Route::get('prodi/{prodi:kode}/{any}', 'ProdiController@butir');
Route::get('edit-profil-prodi', 'ProdiController@editprofil')->name('edit-profil-prodi');
Route::put('edit-profil-prodi/put/{prodi}', 'ProdiController@editprofilPut');
