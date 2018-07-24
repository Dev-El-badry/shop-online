<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item_galleries;
use App\Models\Item;
use Validate, Session, File, Image;

class Item_galleriesController extends Controller
{
    public function update_group($item_id)
    {
    	$images = Item_galleries::where('parent_id', $item_id)->get();
    	$images_count = Item_galleries::where('parent_id', $item_id)->count();

    	return view('manage.item_galleries.update_group', compact('item_id', 'images', 'images_count'));
    }

    public function upload_image($id)
    {
    	return view('manage.item_galleries.upload_image', compact('id'));
    }

    public function do_upload(Request $request, $id)
    {
    	if($request->submit == 'Upload')
        {
            if(is_numeric($id)) {

                $validator = validator($request->all(), [
                    'file'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if($validator->fails())
                {
                    return redirect()->route('item_galleries.upload_image', $id)->withErrors($validator);
                }

                $image = $request->file('file');
                $str = str_random(8);
                $input['image'] = time().'-'.$str.'.'.$image->getClientOriginalExtension();

                $dist = public_path('/item_galleries');
                
                $image->move($dist, $input['image']);
                
                $item = new Item_galleries();
                $item->picture = $input['image'];
                $item->parent_id = $id;

                $item->save();

                Session::flash('item', trans('items.succ_img'));
                return redirect()->route('item_galleries.update_group', $id);

            } else {
                echo $this->not_allowed();
            }
        }
        elseif($request->submit == 'Cancel')
        {
            return redirect()->route('item_galleries.update_group', $id);
        }
    }

    private function delete_process($id)
    {
    	$item = Item_galleries::findOrFail($id);
        $big_img = public_path('/item_galleries/').$item->picture;

        if(file_exists($big_img) ) 
        {
            
            File::delete($big_img);
        }
    }

    public function delete_config($id)
    {
    	return view('manage.item_galleries.delete_config', compact('id'));
    }

    public function destroy(Request $request, $id)
    {
    	
$parent_id = Item_galleries::find($id)->first()->parent_id;
		if($request->submit == 'Yes - I want Delete Image') {

	        if(is_numeric($id))
	        {
	        	
	           $this->delete_process($id);
	           $item = Item_galleries::findOrFail($id)->delete();

	           Session::flash('item_del', trans('items.del_image'));
	           return redirect()->route('item_galleries.update_group', $parent_id);

	        }
		} elseif($request->submit == 'Finished')
		{
			return redirect()->route('item_galleries.update_group', $parent_id);
		}
      
    }
}
