<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store_information;
use App\Models\SocialNetwork;
use App\Models\ShopDate;
use Validator, Image, File, Session;

class Store_infoController extends Controller
{
    public function store(Request $request, $update_id)
    {
    	if(is_numeric($update_id))
    	{

    		$requests = $request->only('store_title', 'description', 'phone_number', 'address1', 'address2', 'email', 'country', 'town', 'postal_code', 'latitude', 'longitude', 'file');

    		$rules = [
    			'store_title.*'=> 'required',
    			'description.*'=> 'required',
    			'phone_number'=> 'required|string|min:5',
    			'address1'=>  'required',
    			'email'=> 'required|email',
    			'country'=> 'required|min:3',
    			'town'=> 'required|min:3',
    			'postal_code'=>  'required|regex:/\b\d{5}\b/',
    			'latitude'=> 'required',
    			'longitude'=> 'required',
    			'file'=> 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    		];
    		$validator = Validator::make($requests, $rules);

    		if($validator->fails())
    		{
    			return redirect()->route('store_info.update', $update_id)->withErrors($validator);
    		}
    		
    		$store_info = Store_information::findOrFail($update_id);
    		$store_info->store_title = serialize($request->store_title);
    		$store_info->description = serialize($request->description);
    		$store_info->phone_number = $request->phone_number;
    		$store_info->address1 = $request->address1;
    		$store_info->address2 = $request->address2;
    		$store_info->email = $request->email;
    		$store_info->country = $request->country;
    		$store_info->town = $request->town;
    		$store_info->postal_code = $request->postal_code;
    		$store_info->latitude = $request->latitude;
    		$store_info->longitude = $request->longitude;
    		
    		$store_info->save();
    		if(isset($request->file))
    			$this->do_upload($update_id, $request->file);
    		
    		Session::flash('item', trans('store_info.alert_success'));
       		return redirect()->route('store_info.update', $update_id);
    	}
    }

    public function update($update_id)
    {
    	$info = Store_information::findOrFail($update_id);
    	return view('manage.store_information.edit', compact('update_id', 'info'));
    }

    public function view($update_id)
    {
    	$info = Store_information::findOrFail($update_id);
    	return view('manage.store_information.view')->withInfo($info);
    }

    public function social_media($update_id)
    {
    	$social_networks = Store_information::where('id', $update_id)->with('social_networks')->first();
    	$social_networks_count = Store_information::where('id', $update_id)->with('social_networks')->first()->social_networks->count();
    	
    	return view("manage.store_information.update_social_media", compact('social_networks', 'social_networks_count', 'update_id'));

    }

    public function store_social_media(Request $request, $update_id)
    {
    	if($request->submit == 'Submit')
    	{
    		$requests = $request->only('icons', 'url', 'title', 'submit');
    		$validator = Validator::make($requests, [
    			'icons'=> 'required',
    			'url'=> 'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
    			'title'=> 'required|min:3'
    		]);

    		if($validator->fails())
    		{
    			return redirect()->route('store_info.social_media', $update_id)->withErrors($validator);
    		}

    		$social_media = new SocialNetwork();
    		$social_media->icons = $request->icons;
    		$social_media->url = $request->url;
    		$social_media->title = $request->title;
    		$social_media->parent_id = $update_id;
    		$social_media->save();

    		Session::flash('item', trans('store_info.alert_store'));
    		return redirect()->route('store_info.social_media', $update_id);
    	} 
    }

    public function delete_account(Request $request)
    {
    	if(is_numeric($request->account_id))
    	{
    		$account_id = $request->account_id;

    		$social_media = SocialNetwork::findOrFail($account_id);
    		$social_media->delete();

    		Session::flash('item_del', trans('store_info.alert_del'));
    		return 1;
    	}
    }

    public function do_upload($update_id, $file)
    {
        $image = $file;

        $input['image'] = time(). '-' .str_random(6) .'.'.$image->getClientOriginalExtension();
        $dist = public_path('/store_pics');
        $image->move($dist, $input['image']);
        
        $image_file = Store_information::findOrFail($update_id)->picture;
        $this->config_update_image($image_file);

        $store_info = Store_information::findOrFail($update_id);
        $store_info->picture = $input['image'];
        $store_info->save();
    }

    private function config_update_image($image_name)
    {
    	$image_path = public_path('store_pics/') .$image_name;
    	if(file_exists($image_path))
    	{
    		File::delete($image_path);
    	}
    }

    public function update_times($update_id)
    {	
    	if(is_numeric($update_id))
    	{
    		$shop_dates = Store_information::where('id', $update_id)->with('shop_dates')->first();
	    	$date = ShopDate::where('parent_id', $update_id)->first();
	    	return view("manage.store_information.update_work_dates", compact('shop_dates', 'update_id', 'date'));
    	}
    }

    public function submit_update(Request $request, $update_id, $date_id)
    {
    	if($request->submit == 'Submit')
    	{
    		$date = ShopDate::findOrFail($date_id);
    		$date->sat_from = $request->sat_from;
    		$date->sat_to = $request->sat_to;
    		$date->sat_status = $request->sat_status;

    		$date->sun_from = $request->sun_from;
    		$date->sun_to = $request->sun_to;
    		$date->sun_status = $request->sun_status;

    		$date->mon_from = $request->mon_from;
    		$date->mon_to = $request->mon_to;
    		$date->mon_status = $request->mon_status;

    		$date->tue_from = $request->tue_from;
    		$date->tue_to = $request->tue_to;
    		$date->tue_status = $request->tue_status;

    		$date->wed_from = $request->wed_from;
    		$date->wed_to = $request->wed_to;
    		$date->wed_status = $request->wed_status;

    		$date->thu_from = $request->thu_from;
    		$date->thu_to = $request->thu_to;
    		$date->thu_status = $request->thu_status;

    		$date->fri_from = $request->fri_from;
    		$date->fri_to = $request->fri_to;
    		$date->fri_status = $request->fri_status;

    		$date->parent_id = $update_id;
    		$date->save();

    		Session::flash('item', trans('store_info.alert_date'));
    		return redirect()->route('store_info.update_times', $update_id);
    	}
    }

}
