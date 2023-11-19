<?php
Route::get('indikator-lam', 'IndikatorController@index_lam')->name('indikator-lam');
Route::get('indikator/{jenjang}', 'IndikatorController@index')->name('indikator-jenjang');
Route::post('indikator/store', 'IndikatorController@store');
Route::get('indikator/input-score/{indikator}', 'IndikatorController@inputScore');
Route::post('indikator/store-score', 'IndikatorController@storeScore');
Route::get('indikator/cek-score/{indikator}', 'IndikatorController@cekScore');

Route::get('indikator/konfirmasi/{indikator}', 'IndikatorController@konfirmasi');
Route::delete('indikator/hapus/{indikator}', 'IndikatorController@hapusIndikator');
Route::get('indikator/edit/{id}', 'IndikatorController@editFormIndikator');
Route::put('indikator/put/{id}', 'IndikatorController@putIndikator');

Route::get('indikator/konfrimasi-score/{score}', 'IndikatorController@konfirmasiScore');
Route::delete('indikator/score-hapus/{score}', 'IndikatorController@hapusScore');
Route::get('indikator/score/edit/{score}', 'IndikatorController@editScore');
Route::put('indikator/score/put/{score}', 'IndikatorController@putScore');
