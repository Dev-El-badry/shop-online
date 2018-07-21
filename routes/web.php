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

Route::get('/home', function() {
	return view('home');
});

Auth::routes();
Route::get('/users/logout', 'Auth\LoginController@userLogout')->name('user.logout');
//Admin Area
Route::prefix('dvilsf')->group(function() {

	Route::get('/login', 'Auth\AdminAuthController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\AdminAuthController@login')->name('admin.login.submit');
	Route::get('/logout', 'Auth\AdminAuthController@logout')->name('admin.logout');

	//forget password
	Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset');
	Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');
});

Route::prefix(LaravelLocalization::setLocale())->group(function() {

	Route::prefix('manage')->middleware('auth:admin')->group(function() {

		//Dashboard
		Route::get('/', 'DashboardController@index');
		Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');

		//items
		Route::resource('/items', 'ItemController');
		Route::prefix('items')->group(function() {
			
			//Upload Image
			Route::get('/upload_image/{id}', 'ItemController@upload_image')->name('upload_image');
			Route::post('/fileUpload/{id}', 'ItemController@fileUpload')->name('fileUpload');
			Route::post('/delete_image', 'ItemController@delete_image')->name('delete_image');

			//Upload File PDF
			Route::get('/upload_file/{id}', 'ItemController@upload_file')->name('upload_file');
			Route::post('/fileUploadPdf/{id}', 'ItemController@fileUploadPdf')->name('fileUploadPdf');
			Route::post('/delete_pdf', 'ItemController@delete_pdf')->name('delete_pdf');
			Route::post('/downloadFile', 'ItemController@downloadFile')->name('downloadFile');

			//delete config
			Route::get('/delete_config/{update_id}', 'ItemController@delete_config')->name('delete_item');
		});

		Route::prefix('item_color')->group(function() {
			Route::get('/update/{id}', 'Item_colorController@update')->name('update_color');
			Route::post('/store/{id}', 'Item_colorController@store')->name('store_color');
			Route::post('/delete_color', 'Item_colorController@delete_color')->name("delete_color");
		});

		Route::prefix('item_size')->group(function() {
			Route::get('/update/{id}', 'Item_sizeController@update')->name('update_size');
			Route::post('/store/{id}', 'Item_sizeController@store')->name('store_size');
			Route::post('/delete_size', 'Item_sizeController@delete_size')->name("delete_size");
		});

		//Categories
		Route::resource('/category', 'CategoryController');

		Route::prefix('category')->group(function() {
			Route::post('/sort', 'CategoryController@sort');
			Route::get('/del_config/{id}', 'CategoryController@del_config')->name('cat_del_config');
			Route::get('/upload_image/{id}', 'CategoryController@upload_image')->name('upload_cat_pic');
			Route::post('/do_upload/{id}', 'CategoryController@do_upload')->name('do_upload_cat_pic');
			Route::post('/delete_image', 'CategoryController@delete_image')->name('delete_cat_pic');
		});

		//Cat Assign
		Route::prefix('cat_assign')->group(function() {

			Route::get('/update/{update_id}', 'Cat_assignController@update')->name('update_cat_assign');
			Route::post('/store/{update_id}', 'Cat_assignController@store')->name('store_item_category');
			Route::post('/delete', 'Cat_assignController@delete')->name('del_cat_assign');
		});
		
	});
	
	
});
