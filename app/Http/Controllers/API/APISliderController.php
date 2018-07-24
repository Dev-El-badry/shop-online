<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Slide;
use Input;
class APISliderController extends Controller
{
    public function get_slider($slug_url=null)
    {
    	$slider = Slider::where('target_url', '=', $slug_url)->with('slides')->first();
    	$slider_count = Slider::where('target_url', '=', $slug_url)->count();

    	try {
    		if($slider_count>0)
	    	{
	    		return response()->json(['success'=>true, 'data'=> $slider->toArray()], 200);
	    	}
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
    	}

    	return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }
}
