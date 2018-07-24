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
      $query = $request->search;
      $cat_id = $request->cat_id;
      $price = $request->price;

      $items = DB::table('items')
              ->join('cat_assign', 'items.id', '=', 'cat_assign.item_id')
              ->join('categories', 'cat_assign.cat_id', '=', 'categories.id')
              ->get();
      dd($items);

    }
}
