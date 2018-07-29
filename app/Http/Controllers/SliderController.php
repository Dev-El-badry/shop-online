<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Models\Slide;
use Validator, Session;
use Image, File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('id', 'desc')->paginate(10);
        return view('manage.sliders.index')->withSliders($sliders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->submit == 'Submit')
        {
            $requests = $request->only('slider_title');
            $rules = [
                'slider_title'=> 'required',
                
            ];
            $validator = Validator::make($requests, $rules);
            if($validator->fails())
            {
                return redirect()->route('sliders.create')->withErrors($validator)->withInput();
            }

            $slider = new Slider();
            $slider->slider_title = $request->slider_title;
            
            $slider->save();

            Session::flash('item', trans('slider.alert_add'));
           
            return redirect()->route('sliders.edit', $slider->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(is_numeric($id))
        {
            $slider = Slider::findOrFail($id);
            return view('manage.sliders.edit', compact('slider'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         if($request->submit == 'Submit')
        {
            $requests = $request->only('slider_title');
            $rules = [
                'slider_title'=> 'required',
                
            ];
            $validator = Validator::make($requests, $rules);
            if($validator->fails())
            {
                return redirect()->route('sliders.create')->withErrors($validator)->withInput();
            }

            $slider = Slider::findOrFail($id);
            $slider->slider_title = $request->slider_title;

            $slider->save();

            Session::flash('item', trans('slider.alert_update'));
           
            return redirect()->route('sliders.edit', $slider->id);
        } elseif($request->submit == 'Cancel')
        {
            return redirect()->route('sliders.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->submit == 'Yes - I want Delete Slider')
        {
            if(is_numeric($id))
            {
                $this->delete_process_slider($id);
                
                Slider::findOrFail($id)->delete();
                Session::flash('item', trans('slider.delete_slide_alert'));
                return redirect()->route('sliders.index');
            }
        } elseif($request->submit == 'Finished') {
            return redirect()->route('sliders.edit', $id);
        }
    }

    public function delete_config($id)
    {
        return view('manage.sliders.delete_config')->with(['slider_id'=>$id]);
    }

    public function delete_process_slider($id)
    {
        $slide = Slider::findOrFail($id)->with('slides')->first();
        foreach ($slide->slides as $row) {
            $this->delete_process($row->id);
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
