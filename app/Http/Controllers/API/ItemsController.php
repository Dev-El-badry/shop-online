<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\Item;
use App\Models\Category;
use Input;
use App\Models\Item_color;
use App\Models\Item_size;

class ItemsController extends Controller
{

	public function get_all_items_by_cat($cat_id)
	{
		if(is_numeric($cat_id))
		{
            $items = Category::where('id', $cat_id)->where('for_what', 0)->with('items')->first();
            $num_rows = Category::find($cat_id)->count();


            try {
                
                if($num_rows>0)
                {
                    return response()->json(['success'=> true, 'data'=> $items->items->toArray()],200);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                return response()->json(['success'=> false, 'message'=> 'error occured'], 500);
            }

            return response()->json(['success'=> false, 'message'=> 'not found records in database'], 404);
		}
	}

    public function get_item_by_id($update_id)
    {
        $item = Item::where('id',$update_id)->first();
        $num_rows = Item::where('id',$update_id)->count();

       if(is_numeric($update_id))
       {
         try {
                
            if($num_rows>0)
            {
                return response()->json(['success'=> true, 'data'=> $item->toArray()],200);
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
            return response()->json(['success'=> false, 'message'=> 'error occured'], 500);
        }

        return response()->json(['success'=> false, 'message'=> 'not found records in database'], 404);
       }
    }

    public function get_item_by_url()
    {
        $url = Input::get('url');
        $slug = Input::get('slug');

        if(!empty($url) && !empty($slug))
        {
            if($slug == 'en')
            {
                $item = Item::where('item_url', $url)->first();
                $num_rows = Item::where('item_url', $url)->count();
            } else {
                $item = Item::where('item_url_ar', $url)->first();
                $num_rows = Item::where('item_url_ar', $url)->count();
            }
            

            try {
                    
                if($num_rows>0)
                {
                    return response()->json(['success'=> true, 'data'=> $item->toArray()],200);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                return response()->json(['success'=> false, 'message'=> 'error occured'], 500);
            }

            return response()->json(['success'=> false, 'message'=> 'not found records in database'], 404);
       }
    }

    public function get_colors_item($update_id)
    {
        if(is_numeric($update_id))
        {
            $colors_item = Item::where('id',$update_id)->with('item_color')->first();
            $colors_item_num_rows = Item_color::where('item_id', $update_id)->with('items')->count();
            
            try {
                if($colors_item_num_rows >0)
                {
                    return response()->json(['success'=>true, 'data'=> $colors_item->item_color->toArray()], 200);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                return response()->json(['success'=>false, 'error'=> $error], 500);
            }

            return response()->json(['success'=>false, 'error'=> 'not found data in database'], 404);
        }
    }

    public function get_sizes_item($update_id)
    {
        if(is_numeric($update_id))
        {
            $sizes_item = Item::where('id',$update_id)->with('item_size')->first();
            $sizes_item_num_rows = Item_size::where('item_id', $update_id)->with('items')->count();
            
            try {
                if($sizes_item_num_rows >0)
                {
                    return response()->json(['success'=>true, 'data'=> $sizes_item->item_size->toArray()], 200);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                return response()->json(['success'=>false, 'error'=> $error], 500);
            }

            return response()->json(['success'=>false, 'error'=> 'not found data in database'], 404);
        }
    }

    public function get_item_galleries($item_id)
    {
        $slides = Item::where('id', $item_id)->with("item_galleries")->first();
        $slides_count = Item::where('id', $item_id)->with("item_galleries")->count();
        
         try {
                if($slides_count >0)
                {
                    return response()->json(['success'=>true, 'data'=> $slides->item_galleries->toArray()], 200);
                }
            } catch (Exception $e) {
                $error = $e->getMessage();
                return response()->json(['success'=>false, 'error'=> $error], 500);
            }

            return response()->json(['success'=>false, 'error'=> 'not found data in database'], 404);
    }
    
}
