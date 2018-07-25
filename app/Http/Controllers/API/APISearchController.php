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
    $query = $request->query;
    $cat_id = $request->cat_id;
    $price = $request->price;

    $items = DB::table('items')
            ->join('cat_assign', 'items.id', '=', 'cat_assign.item_id')
            ->join('categories', 'categories.id', '=', 'cat_assign.cat_id');
  
    if(is_numeric($cat_id))
    {
      $items->where('cat_assign.cat_id', '=', $cat_id);
    }

    if(!empty($price))
    {
      $items->where('items.item_price', '<=', $price);
    }

    $items = $items->select('items.id')->groupBy('items.id')->get();

    dd($items);

  }
}
