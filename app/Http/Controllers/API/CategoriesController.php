<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Session;
use DB;
use Input;

class CategoriesController extends Controller
{
    public function get_all_main_categories($for_what)
    {
    	$categories = DB::table('categories')->where('cat_parent_id', 0)->where('for_what', $for_what)->orderBy('priority', 'asc')->get();
        

    	if(is_null($categories))
    	{
    		return response()->json(['success'=> false, 'message' => 'not found data in database'], 404);
    	}

    	return response()->json(['success'=> true, 'data'=> $categories->toArray()], 200);
    }

    public function get_category_by_url()
    {
    	$url = Input::get('url');
    	$slug = Input::get('slug');
    	
    	if($slug == 'en')
    	{
    		$category = Category::where('cat_url', $url)->first();
    	}else {

    		$category = Category::where('cat_url_ar', $url)->first();
    	}

    	if(is_null($category))
    	{
    		return response()->json(['success'=> false, 'message' => 'not found in database'], 404);
    	}

    	return response()->json(['success'=> true, 'data' => $category->toArray()], 200);
    }

    public function get_sub_categories($cat_id)
    {
    	$categories = DB::table('categories')->where('cat_parent_id', $cat_id)->get();
    	if(!is_null($categories))
    	{
    		return response()->json(['success'=> true, 'data'=> $categories->toArray()], 200);
    	} else {
    		return response()->json(['success'=> false, 'message'=> 'not found in database'], 404);
    	}

    }
}
