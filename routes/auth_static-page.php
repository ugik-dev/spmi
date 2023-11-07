<?php

Route::resource('halaman', 'StaticPageController')->except(['show']);
Route::get('detail-halaman/{page}', 'StaticPageController@detail')->name('halaman.detail');
Route::get('datatable-halaman', 'StaticPageController@datatable')->name('halaman.datatable');
