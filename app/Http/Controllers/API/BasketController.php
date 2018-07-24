<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB, Validator;
use App\Models\Item;
use App\Models\User;
use App\Models\Basket;
use Response;

class BasketController extends Controller
{
    public function add_to_basket(Request $request)
    {
    	//NOTE: Request: item_id, user_id, tax, item_qty, item_color, item_size, ip_address,  item_title
    	$requests = $request->only(
				    			'item_id',
				    		 	'shopper_id',
				    		 	'tax',
				    		  	'item_qty',
							   	'item_color', 
							   	'item_size', 
							   	'ip_address', 
							   	'item_title'
		);
    	$rules = [
    		'item_id'=> 'required|integer',
    		'item_title'=> 'required|string',
    		'shopper_id'=> 'required|integer',
    		'tax'=> 'required|integer',
    		'item_qty'=> 'required|integer',
    		'item_color'=> 'required|string',
    		'item_size'=> 'required|string',
    		'ip_address'=> 'required|ip',
    	];
    	$validator = Validator::make($requests, $rules);
    	if($validator->fails())
    	{
    		return response()->json(['success'=> false, 'errors'=> $validator->errors()], 401);
    	}

    	try {
    		$item = Item::find($request->item_id)->first();
    		$user = User::find($request->shopper_id)->first();
    		$basket = new Basket();

    		$basket->item_title = $request->item_title; //serlization value
    		$basket->price = $item->item_price;
    		$basket->tax = $request->tax;
    		$basket->item_id = $request->item_id;
    		$basket->item_qty = $request->item_qty;
    		$basket->item_color = $request->item_color;
    		$basket->item_size = $request->item_size;
    		$basket->shopper_id = $request->shopper_id;
    		$basket->ip_address = $request->ip_address;

    		$basket->save();
    		return response()->json(['success'=> true, 'message'=> 'successfully added item to basket .. thank you'], 200);

    	} catch (Exception $e) {
    		return response()->json(['sucess'=> false, 'error'=> $e->getMessage()], 500);
    	}
    }

    public function show_basket($user_id)
    {
    	if(is_numeric($user_id))
    	{
    		$basket_items = User::find($user_id)->with('basket')->first();
    		$basket_items_count = User::find($user_id)->count();

    		try {
    			if($basket_items_count >0)
    			{
    				return response()->json(['success'=> true, 'data'=> $basket_items->basket->toArray()], 200);
    			}
    		} catch (Exception $e) {
    			return response()->json(['success'=> false, 'error'=> $e->getMessage()], 500);
    		}

    		return response()->json(['success'=> false, 'message'=> 'not found records in database'], 404);
    	}
    }

    // public function push_to_order(Request )
    // {

    // }
}
