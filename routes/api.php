<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function() {

	Route::post('register', 'API\Auth\RegisterController@register')->name('api.user.register');
	Route::post('verify', 'API\Auth\RegisterController@verifyUser');
	Route::post('login', 'API\Auth\LoginController@login')->name('api.user.login');
	Route::post('recover', 'API\Auth\RecoverPasswordController@recover')->name('api.user.recover');
});

Route::group(['middleware'=> ['jwt.auth']], function() {
	//users
	Route::post('users/logout', 'API\Auth\LoginController@logout')->name('api.user.logout');
	Route::post('users/add_details/{user_id}', 'API\APIUserController@add_details');
	Route::post('users/update_passwords/{user_id}', 'API\APIUserController@update_passwords');
	Route::post('users/do_upload/{user_id}', 'API\APIUserController@do_upload');

	//Categories
	Route::get('categories/get_all_main_categories/{for}', 'API\CategoriesController@get_all_main_categories');
	Route::get('categories/get_sub_categories/{cat_id}', 'API\CategoriesController@get_sub_categories');
	Route::get('categories/get_category_by_url', 'API\CategoriesController@get_category_by_url');

	//Items
	Route::get('items/get_all_items_by_cat/{cat_id}', 'API\ItemsController@get_all_items_by_cat');
	Route::get('items/get_item_by_url', 'API\ItemsController@get_item_by_url');
	Route::get('items/get_item_galleries/{item_id}', 'API\ItemsController@get_item_galleries');

	//localhost:8000/api/items/get_item_by_url?url=القطعه-الاولي&slug=ar
	Route::get('items/get_item_by_id/{update_id}', 'API\ItemsController@get_item_by_id');
	Route::get('items/get_colors_item/{update_id}', 'API\ItemsController@get_colors_item');
	Route::get('items/get_sizes_item/{update_id}', 'API\ItemsController@get_sizes_item');

	//Basket
	Route::post('basket/add_to_basket', 'API\BasketController@add_to_basket');
	Route::get('basket/show_basket/{user_id}', 'API\BasketController@show_basket');

	//Favourite
	Route::get('favourite/add_to_favourite/{item_id}/{user_id}', 'API\FavouriteController@add_to_favourite');
	Route::get('favourite/get_all_favourites/{user_id}', 'API\FavouriteController@get_all_favourites');
	Route::get('favourite/delete_from_favourite/{item_id}/{user_id}', 'API\FavouriteController@delete_from_favourite');

	//sliders
	Route::get('sliders/get_slider', 'API\APISliderController@get_slider');

	//CMS
	Route::get('cms/get_webpages', 'API\APICMSController@get_webpages');

	//Blogs
	Route::get('blogs/get_all', 'API\APIBlogController@get_all');
	Route::get('blogs/get_by_id/{id}', 'API\APIBlogController@get_by_id');
	Route::get('blogs/get_by_cat_id/{id}', 'API\APIBlogController@get_by_cat_id');

	//Homepage Blocks AND Homeoffer Blocks
	Route::get('blocks/get_all', 'API\APIHomepageController@get_all');

	//Enquiries
	Route::post('enquiries/submit_message', 'API\APIEnquiriesController@submit_message');

  //search
  Route::post('items/search', 'API\APISearchController@search');

  //Store info
  Route::get('store_info/get_all_info', 'API\APIStoreInfoController@get_all_info');

});
