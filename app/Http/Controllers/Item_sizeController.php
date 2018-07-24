<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_size;
use Session;
use DB;
use Validator;

class Item_sizeController extends Controller
{
    //mange item sizes
    public function update($update_id)
    {
        if(is_numeric($update_id))
        {
            $num_rows = Item_size::where('item_id', $update_id)->count();
            if($num_rows >0)
            {
                $data['sizes'] = Item_size::where('item_id', $update_id)->get();
            }

            $data['num_rows'] = $num_rows;
            $data['update_id'] = $update_id;
            return view('manage.item_size.update')->withData($data);
            
        }
    } 

    //store function to store sizes in database
    public function store(Request $request, $id)
    {
        if($request->submit == 'Submit')
        {
            $validator = Validator::make($request->all(), [
                'size.*'=> ['required' ],
            ]);

            if($validator->fails())
            {
                return redirect()->route('update_size', $id)->withErrors($validator);
            }

            $item_size = new Item_size();
            $item_size->size = serialize($request->size);
            $item_size->item_id = $id;
            $item_size->save();

            Session::flash('item', trans('items.success_size'));
            return redirect()->route('update_size', $id);
        } elseif($request->submit == 'Finished') {
            return redirect()->route('items.edit', $id);
        }
    }

    //delete item size
    public function delete_size(Request $request) 
    {
        $id = $request->id;
        if(is_numeric($id))
        {
            $item = Item_size::find($id);
            $item->delete();
            Session::flash('item_del', trans('items.delete_done'));
            return 1;
        }
    }
}
