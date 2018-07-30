<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Store_information;

class APIStoreInfoController extends Controller
{
    public function get_all_info()
    {
      $store_info = Store_information::orderBy('id', 'desc')->with('social_networks')->with('shop_dates')->first();
      $store_info_count = Store_information::orderBy('id', 'desc')->with('social_networks')->with('shop_dates')->count();
      try {
        if($store_info_count>0)
        {
          return response()->json(['success'=>true, 'data'=> $store_info->toArray()], 200);
        }
      } catch (Exception $e) {
        return response()->json(['success'=>false, 'error'=> $e->getMessage()], 500);
      }

      return response()->json(['success'=>false, 'message'=> 'not found data'], 404);
    }
}
