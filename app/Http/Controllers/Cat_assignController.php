<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cat_assign;
use App\Models\Category;
use LaravelLocalization;
use Session;

class Cat_assignController extends Controller
{
	private function get_parent_cat_title($parent_id)
	{
		if(is_numeric($parent_id))
		{
			$category = Category::where('cat_parent_id', $parent_id)->first();
			$cat_title = unserialize($category->cat_title)[LaravelLocalization::getCurrentLocale()];

			return $cat_title;
		}
	}

	private function get_dropdown_options()
	{
		$categories = Category::where('for_what', 0)->get();

		foreach ($categories as $row) {
			
			if($row->cat_parent_id == 0)
			{
				$parent_name = unserialize($row->cat_title)[LaravelLocalization::getCurrentLocale()];
				$options[$row->id] = $parent_name;
			} else {

				$options[$row->id] = $this->get_parent_cat_title($row->cat_parent_id) . trans('cat_assign.arrow') . unserialize($row->cat_title)[LaravelLocalization::getCurrentLocale()];
			}
		}

		if(!isset($options))
		{
			$options[''] = '';
		}

		return $options;
	}

    public function update($update_id)
    {
    	if(is_numeric($update_id))
    	{
    		//do something
    		$options = $this->get_dropdown_options();
    		
    		$cats_assign = Cat_assign::where('item_id', $update_id)->get();
    		$num_rows = Cat_assign::where('item_id', $update_id)->count();

    		foreach ($cats_assign as $row) {
    			$cat_id = $row->cat_id;
    			$category = Category::where('id', $cat_id)->where('for_what', 0)->first();
    			if($category->cat_parent_id == 0)
    			{
    				$cat_assigned[$category->id] = unserialize($category->cat_title)[LaravelLocalization::getCurrentLocale()];
    			} else
    			{
    				$cat_assigned[$category->id] = $this->get_parent_cat_title($category->cat_parent_id) . trans('cat_assign.arrow') . unserialize($category->cat_title)[LaravelLocalization::getCurrentLocale()];
    			}
    		}

    		if(!isset($cat_assigned))
    		{
    			$cat_assigned = '';
    		}
    		else
    		{
    			$options = array_diff($options, $cat_assigned);
    		}
    		
    		return view('manage.cat_assign.update', compact('options', 'update_id','cats_assign','num_rows'));
    	}
    }

    public function store(Request $request, $update_id)
    {
    	if($request->submit == 'Finished')
    	{
    		return redirect()->route('items.edit', $update_id);
    	}

    	if(is_numeric($update_id))
    	{
    		$cat_id = $request->cat_id;

    		$cat_assign = new Cat_assign();
    		$cat_assign->cat_id = $request->cat_id;
    		$cat_assign->item_id = $update_id;
    		$cat_assign->save();

    		Session::flash('item', trans('cat_assign.success_msg'));

    		return redirect()->route('update_cat_assign', $update_id);
    	}
    }

    public function delete(Request $request)
    {
    	$update_id = $request->cat_assign_id;
    	if(is_numeric($update_id))
    	{
    		$this->delete_process($update_id);
    		return 1;
    	}
    }

    private function delete_process($update_id)
    {
    	if(is_numeric($update_id))
		{
			$cat_assign = Cat_assign::where('id', $update_id)->delete();
		}
    }
}
