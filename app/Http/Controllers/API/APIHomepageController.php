<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Homepage_Block;

class APIHomepageController extends Controller
{
    public function get_all()
    {
    	$blocks = Homepage_Block::orderBy('priority', 'desc')->with('homepage_offers')->get();

    	$blocks_count = Homepage_Block::orderBy('priority', 'desc')->with('homepage_offers')->count();

    	try {
    		if($blocks_count>0)
	    	{
	    		return response()->json(['success'=>true, 'data'=> $blocks->toArray()], 200);
	    	}
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
    	}

    	return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }
}
