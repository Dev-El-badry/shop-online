<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();



Route::prefix(LaravelLocalization::setLocale())->group(function() {

	Route::prefix('manage')->group(function() {
		Route::get('/', 'DashboardController@index')->name('dashboard');
		Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

		//items
		Route::resource('/items', 'ItemController');
		Route::get('/items/upload_image/{id}', 'ItemController@upload_image')->name('items.upload_image');
		Route::post('/items/fileUpload/{id}', 'ItemController@fileUpload')->name('items.fileUpload');
		Route::post('/items/delete_image', 'ItemController@delete_image')->name('items.delete_image');
		
	});
	
	
});
