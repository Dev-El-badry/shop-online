<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Webpage;

class APICMSController extends Controller
{
    public function get_webpages() {
    	$cats = Webpage::all();
    	$cats_count = Webpage::count();

    	try {
    		if($cats_count>0)
	    	{
	    		return response()->json(['success'=>true, 'data'=> $cats->toArray()], 200);
	    	}
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
    	}

    	return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }
}
