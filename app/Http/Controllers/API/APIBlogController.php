<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\category;


class APIBlogController extends Controller
{
    public function get_by_id($id)
    {
    	$blog = Blog::find($id);
    	$blog_count = Blog::find($id)->count();

    	try {
    		if($blog_count>0)
	    	{
	    		return response()->json(['success'=>true, 'data'=> $blog->toArray()], 200);
	    	}
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
    	}

    	return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }

    public function get_all()
    {
    	$blog = Blog::all();
    	$blog_count = Blog::count();

    	try {
    		if($blog_count>0)
	    	{
	    		return response()->json(['success'=>true, 'data'=> $blog->toArray()], 200);
	    	}
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
    	}

    	return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }

    public function get_by_cat_id($cat_id)
    {
    	$blogs = Category::where('for_what',1)->where('id', $cat_id)->with('blogs')->first();

    	$blog_count = Category::where('for_what',1)->where('id', $cat_id)->with('blogs')->count();

    	try {
    		if($blog_count>0)
	    	{
	    		return response()->json(['success'=>true, 'data'=> $blogs->toArray()], 200);
	    	}
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
    	}

    	return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }
}
