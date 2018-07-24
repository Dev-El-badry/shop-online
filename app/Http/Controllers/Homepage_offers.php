<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Homepage_Offer;
use Validator, Session;

class Homepage_offers extends Controller
{
    public function update($update_id)
    {
    	if(is_numeric($update_id))
    	{
    		$update_id = $update_id;
    		$num_rows = Homepage_Offer::where('block_id', $update_id)->count();
    		$data = Homepage_Offer::where('block_id', $update_id)->get();


    		return view('manage.homepage_offers.update', compact('update_id', 'num_rows', 'data'));
    	}
    }

    public function store(Request $request, $update_id)
    {
    	if(is_numeric($update_id))
    	{
    		if($request->submit == 'Finished')
    		{
    			return redirect()->route('homepage_blocks.edit', $update_id);
    		}

    		$validator = Validator::make($request->all(), ['item_id'=> 'required|numeric']);
    		if($validator->fails())
    		{
    			return redirect()->route('homepage_offers.update', $update_id)->withErrors($validator);
    		}

    		$homepage_offer = new Homepage_Offer();
    		$homepage_offer->item_id = $request->item_id;
    		$homepage_offer->block_id = $update_id;
    		$homepage_offer->save();

    		Session::flash('item', trans('blocks.alert_upload_success'));
    		return redirect()->route('homepage_offers.update', $update_id);
    	}
    }

    public function delete(Request $request) {
    	$id = $request->id;
    	if(is_numeric($id))
    	{
    		Homepage_Offer::findOrFail($id)->delete();
    		Session::flash('item_del', trans('blocks.alert_delete'));

    		return 1;
    	}
    }

}
