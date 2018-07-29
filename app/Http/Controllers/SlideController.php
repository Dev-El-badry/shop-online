<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Slide;
use Validator, Session;
use Image, File;
use App\Models\Item;
use App\Traits\SiteSettings;
use Input;

class SlideController extends Controller
{
    use SiteSettings;
    public function update_group($slider_id)
    {
    	$slides = Slider::findOrFail($slider_id)->with('slides')->first();
    	$slides_count = Slide::where('parent_id', $slider_id)->count();

        $slidesIds = Slide::pluck('item_id');
        $items = Item::whereNotIn('id', $slidesIds)->get();
        $currencySymbol =  $this->get_currency_symble();

    	return view('manage.slides.update_group', compact('slides', 'slides_count', 'slider_id', 'items', 'currencySymbol'));
    }

    public function store(Request $request, $slider_id)
    {   
        $item_id = Input::post('item_id');
        $parent_id = Input::post('parent_id');

        if((is_numeric($item_id)) AND (is_numeric($parent_id)))
        {
            
            $slide = new Slide();
            $slide->parent_id = $parent_id;
            $slide->item_id = $item_id;
            

            $slide->save();
            
            Session::flash('item', trans('alert_add_slide'));
            return response()->json([
                'result'=> true,
                'slide_id'=> $slide->id
            ]);
            
        }
        
    }

    public function view($slide_id)
    {
    	$slide = Slide::findOrFail($slide_id);
    	return view('manage.slides.view')->withSlide($slide);
    }

    public function update(Request $request, $slide_id)
    {
        $parent_id = Slide::findOrFail($slide_id)->first()->parent_id;
    	if($request->submit == 'Submit')
    	{
            
    		$slide = Slide::findOrFail($slide_id);
    		$slide->target_url = $request->target_url;
    		$slide->alt_text = $request->alt_text;
    		$slide->save();

    		Session::flash('item', trans('slider.alert_update_slide'));
    		return redirect()->route('slides.view', $slide->id);
    	} elseif($request->submit == 'Cancel')
        {
            return redirect()->route('slides.update_group', $parent_id);
        }
    }

    public function upload_image($slide_id)
    {
    	return view('manage.slides.upload_image', compact('slide_id'));
    }

    public function do_upload(Request $request, $slide_id)
    {
    	 if($request->submit == 'Upload')
        {
            if(is_numeric($slide_id)) {

                $validator = validator($request->all(), [
                    'file'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if($validator->fails())
                {
                    return redirect()->route('slides.upload_image', $slide_id)->withErrors($validator);
                }

                $image = $request->file('file');

                $input['image'] = time().'.'.$image->getClientOriginalExtension();

                $dist = public_path('/slides');
                
                $image->move($dist, $input['image']);
                
                $slide = Slide::findOrFail($slide_id);
                $slide->picture = $input['image'];
                $slide->save();

                Session::flash('item', 'Successfully Uploaded Image!');
                return redirect()->route('slides.view', $slide_id);

            } else {
                echo $this->not_allowed();
            }
        }
        elseif($request->submit == 'Cancel')
        {
            return redirect()->route('slides.view', $slide_id);
        }

    }

    public function delete_config($slide_id)
    {
    	return view('manage.slides.delete_config', compact('slide_id'));
    }

    public function destroy(Request $request, $slide_id)
    {
    	if($request->submit == 'Yes - I want Delete Slide')
    	{
    		if(is_numeric($slide_id))
	        {
	            $this->delete_process($slide_id);
	            $parent_id = Slide::find($slide_id)->first()->parent_id;
	            $slide = Slide::findOrFail($slide_id)->delete();
	            Session::flash('item', trans('slider.delete_slide_alert'));
	            return redirect()->route('slides.update_group', $parent_id);
	        }
    	} elseif($request->submit == 'Finished') {
    		return redirect()->route('slides.view', $slide_id);
    	}
    }

    private function delete_process($slide_id)
    {
    	$slide = Slide::findOrFail($slide_id);
        $slide_image = public_path('slides/').$slide->picture;
       
        if(file_exists($slide_image)) 
        {
            
            File::delete($slide_image);
        }
    }

}
