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


		//Users
		Route::prefix('users')->group(function() {

			Route::get('/index', 'UsersController@index')->name('users.index');
			Route::get('/', 'UsersController@index')->name('users.index');
			Route::get('/view/{user_id}', 'UsersController@view')->name('users.view');
			Route::get('/delete_config/{user_id}', 'UsersController@delete_config')->name('users.delete_config');
			Route::delete('/destroy/{user_id}', 'UsersController@destroy')->name('users.destroy');
		});


		//items
		Route::resource('/items', 'ItemController', ['except'=> 'show']);
		Route::prefix('items')->group(function() {

			//search items
			Route::post('/search', 'ItemController@search')->name('items.search');

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
		Route::resource('/category', 'CategoryController', ['except'=> ['show', 'index']]);
		Route::get('category/index/{status}', 'CategoryController@index')->name('category.index');

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

		//CMS
		Route::resource('web_pages', 'CMSController', ['except'=> 'show']);
		Route::get('web_pages/delete_config/{id}', 'CMSController@deletePage')->name('cms.delete');

		//Blogs
		Route::resource('blogs', 'BlogController', ['except'=> 'show']);
		Route::prefix('blogs')->group(function() {
			Route::get('delete_config/{id}', 'BlogController@delete_config')->name('blogs.delete_config');
			Route::get('upload_image/{id}', 'BlogController@upload_image')->name('blogs.upload_image');
			Route::post('do_upload/{id}', 'BlogController@do_upload')->name('blogs.do_upload');
			Route::post('delete_image', 'BlogController@delete_image')->name('blogs.delete_image');

			//category assign
			Route::get('get_cat_assign/{blog_id}', 'BlogController@get_cat_assign')->name('blogs.get_cat_asign');
			Route::post('submit_action/{blog_id}', 'BlogController@submit_action')->name('blogs.submit_action');
			Route::post('delete_cat_assign', 'BlogController@delete_cat_assign')->name('blogs.delete_cat_assign');
		});

		//Homepageblocks
		Route::resource('homepage_blocks', 'HomepageBlock', ['except'=> 'show']);
		Route::post('homepage_blocks/sort', 'HomepageBlock@sort');
		Route::get('homepage_blocks/delete_config/{id}', 'HomepageBlock@delete_config')->name('homepage_blocks.delete_config');

		//HoepageOffers
		Route::get('update/{id}', 'Homepage_offers@update')->name('homepage_offers.update');
		Route::post('store/{id}', 'Homepage_offers@store')->name('homepage_offers.store');
		Route::post('delete', 'Homepage_offers@delete')->name('homepage_offers.delete');

		//Sliders
		Route::resource('sliders', 'SliderController');
		Route::get('sliders/delete_config/{slider_id}', 'SliderController@delete_config')->name('sliders.delete_config');
		Route::get('sliders/make_it_only_active/{slider_id}', 'SliderController@make_it_only_active')->name('sliders.make_it_only_active');

		//Slides
		Route::prefix('slides')->group(function() {

			Route::get('update_group/{slider_id}', 'SlideController@update_group')->name('slides.update_group');
			Route::post('store/{slider_id}', 'SlideController@store')->name('slides.store');
			Route::put('update/{slide_id}', 'SlideController@update')->name('slides.update');
			Route::get('view/{slide_id}', 'SlideController@view')->name('slides.view');
			Route::get('upload_image/{slide_id}', 'SlideController@upload_image')->name('slides.upload_image');
			Route::post('do_upload/{slide_id}', 'SlideController@do_upload')->name('slides.do_upload');
			Route::get('delete_config/{slide_id}', 'SlideController@delete_config')->name('slides.delete_config');
			Route::delete('destroy/{slide_id}', 'SlideController@destroy')->name('slides.destroy');

		});

		//Item Galleries
		Route::prefix('item_galleries')->group(function() {

			Route::get('update_group/{item_id}', 'Item_galleriesController@update_group')->name('item_galleries.update_group');
			Route::get('upload_image/{id}', 'Item_galleriesController@upload_image')->name('item_galleries.upload_image');
			Route::post('do_upload/{id}', 'Item_galleriesController@do_upload')->name('item_galleries.do_upload');
			Route::get('delete_config/{id}', 'Item_galleriesController@delete_config')->name('item_galleries.delete_config');
			Route::delete('destroy/{id}', 'Item_galleriesController@destroy')->name('item_galleries.destroy');

		});

		//Enquiries
		Route::prefix('enquiries')->group(function() {
			Route::get('/index', 'EnquiryController@index')->name('enquiries.index');
			Route::get('/', 'EnquiryController@index');
			Route::get('/view/{update_id}', 'EnquiryController@view')->name('enquiries.view');
			Route::post('/submitted_ranking/{update_id}', 'EnquiryController@submitted_ranking')->name('enquiries.submitted_ranking');
		});

		//Store Information
		Route::prefix('store_info')->group(function() {

			Route::get('update/{update_id}', 'Store_infoController@update')->name('store_info.update');
			Route::post('store/{update_id}', 'Store_infoController@store')->name('store_info.store');
			Route::get('view/{update_id}', 'Store_infoController@view')->name('store_info.view');
			Route::get('social_media/{update_id}', 'Store_infoController@social_media')->name('store_info.social_media');
			Route::get('update_times/{update_id}', 'Store_infoController@update_times')->name('store_info.update_times');
			Route::post('submit_update/{update_id}/{date_id}', 'Store_infoController@submit_update')->name('store_info.submit_update');
			Route::post('store_social_media/{update_id}', 'Store_infoController@store_social_media')->name('store_info.store_social_media');
			Route::post('delete_account', 'Store_infoController@delete_account')->name('store_info.delete_account');
			Route::post('do_upload/{update_id}', 'Store_infoController@do_upload')->name('store_info.do_upload');
		});

		//Admins
		Route::prefix('admins')->group(function() {
			Route::get('view/{update_id}', 'AdminController@view')->name('admins.view');
			Route::post('update_admin/{update_id}', 'AdminController@update_admin')->name('admins.update_admin');
			Route::get('update/{update_id}', 'AdminController@update')->name('admins.update');
			Route::get('update_password/{update_id}', 'AdminController@update_password')->name('admins.update_password');
			Route::post('submit_password/{update_id}', 'AdminController@submit_password')->name('admins.submit_password');
		});



	});


});
