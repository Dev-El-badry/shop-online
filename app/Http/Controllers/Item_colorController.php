<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_color;
use Session;
use DB;
use Validator;

class Item_colorController extends Controller
{

	//mange item colors
    public function update($update_id)
    {
    	if(is_numeric($update_id))
    	{
    		$num_rows = Item_color::where('item_id', $update_id)->count();
    		if($num_rows >0)
    		{
    			$data['colors'] = Item_color::where('item_id', $update_id)->get();
    		}

    		$data['num_rows'] = $num_rows;
    		$data['update_id'] = $update_id;
    		return view('manage.item_color.update')->withData($data);
    		
    	}
    } 

    //store function to store colors in database
    public function store(Request $request, $id)
    {
    	if($request->submit == 'Submit')
    	{
	    	$validator = Validator::make($request->all(), [
	    		'color.*'=> ['required'],
	    	]);

	    	if($validator->fails())
	    	{
	    		return redirect()->route('update_color', $id)->withErrors($validator);
	    	}

	    	$item_color = new Item_color();
	    	$item_color->color = serialize($request->color);
	    	$item_color->item_id = $id;
	    	$item_color->save();

	    	Session::flash('item', trans('items.success_color'));
	    	return redirect()->route('update_color', $id);
    	} elseif($request->submit == 'Finished') {
    		return redirect()->route('items.edit', $id);
    	}
    }

    //delete item color
    public function delete_color(Request $request) 
    {
    	$id = $request->id;
    	if(is_numeric($id))
    	{
    		$item = Item_color::find($id);
    		$item->delete();
    		Session::flash('item_del', trans('items.delete_done'));
    		return 1;
    	}
    }

}
