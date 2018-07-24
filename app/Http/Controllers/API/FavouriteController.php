<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\User;

class FavouriteController extends Controller
{
    public function add_to_favourite($item_id, $user_id) 
    {
    	if(is_numeric($item_id) AND is_numeric($user_id))
    	{
    		$data['item_id'] = $item_id;
    		$data['user_id'] = $user_id;
    		
    		try {
    			DB::table('favourite')->insert($data);
    			return response()->json(['success'=> true, 'message'=> 'successfully added to favourite'], 200);
    		} catch (Exception $e) {
    			return response()->json(['success'=> false, 'error'=> $e->getMessage()],500);
    		}
    	}
    }

    public function get_all_favourites($user_id)
    {
    	if(is_numeric($user_id))
    	{
    		$items = User::find($user_id)->with('items')->first();
    		
    		$items_count = User::find($user_id)->with('items')->count();

    		try {
    			if($items_count >0){
    				return response()->json(['success'=> true, 'data'=> $items->items->toArray()], 200);
    			}
    		} catch (Exception $e) {
    			return response()->json(['success'=> false, 'error'=> $e->getMessage()], 500);
    		}

    		return response()->json(['success'=> false, 'message'=> 'not found records in database'], 404);
    	}
    }

    public function delete_from_favourite($item_id, $user_id)
    {
    	if(is_numeric($item_id) AND is_numeric($user_id))
    	{
    		try {
    			DB::table('favourite')->where('item_id', $item_id)->where('user_id', $user_id)->delete();
    			return response()->json(['success'=> true, 'message'=> 'successfully deleted item from favourite'], 200);
    		} catch (Exception $e) {
    			return response()->json(['success'=> false, 'error'=> $e->getMessage()], 500);
    		}
    	}
    }
}
