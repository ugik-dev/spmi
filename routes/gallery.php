<?php
Route::get('/gallery', 'GalleryController@index')->name('gallery.index');
Route::post('/gallery', 'GalleryController@store')->name('gallery.store');
Route::get('/gallery/create', 'GalleryController@create')->name('gallery.create');
