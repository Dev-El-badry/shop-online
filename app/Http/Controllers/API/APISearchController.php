<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Session;
use DB;

class APISearchController extends Controller
{


  public function search(Request $request)
  {
    $query = Input::post('query');
    $cat_id = Input::post('cat_id');
    $price = Input::post('price');

    $items = DB::table('items')
            ->where('item_title', 'like', '%' . $query. '%');

    if(is_numeric($cat_id))
    {
      $items->join('cat_assign', 'items.id', '=', 'cat_assign.item_id')
            ->join('categories', 'categories.id', '=', 'cat_assign.cat_id')
            ->where('cat_assign.cat_id', '=', $cat_id);
    }

    if(!empty($price))
    {
      $items->where('items.item_price', '<=', $price);
    }

    $items = $items->select('items.*')->groupBy('items.id')->paginate(10);
    return response()->json($items);
  
  }
}
