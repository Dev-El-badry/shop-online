<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Validator;
use App\Rules\ArrayNotContainNullValue;
use App\Traits\SiteSettings;
use LaravelLocalization;
use App\Rules\Chk_if_title_unique;
use Session;
use Image;
use File;


class ItemController extends Controller
{
    use SiteSettings;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $items = Item::orderBy('id', 'desc')->paginate(10);
        $currencySymbol =  $this->get_currency_symble();
        return view('manage.items.index')->withItems($items)->withCurrencySymbol($currencySymbol);
    }

    private function delete_process($id) {
        $item = Item::findOrFail($id);
        $big_img = public_path('/items_pics/').$item->big_img;
        $small_img = public_path('/items_pics/').$item->small_img;

        if(file_exists($big_img) AND file_exists($small_img)) 
        {
            
            File::delete($big_img, $small_img);
        }
    }

    public function delete_image(Request $request) 
    {   
        $item_id = $request->id;

        if(is_numeric($item_id))
        {
           $this->delete_process($item_id);
           $item = Item::findOrFail($item_id);
           $item->big_img = null;
           $item->small_img = null;
           $item->save();

           return 1;
        }
        else
        {
            return 0;
        }
    }

    private function generate_thumbnail_image($image)
    {
        $input['imagename'] = time().'-thubmnail.'.$image->getClientOriginalExtension();
        $dist = public_path('/items_pics');
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dist.'/'.$input['imagename']);

        return $input['imagename'];
    }

    public function fileUpload(Request $request, $id) {

        if($request->submit == 'Upload')
        {
            if(is_numeric($id)) {

                $validator = validator($request->all(), [
                    'file'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if($validator->fails())
                {
                    return redirect()->route('items.upload_image', $id)->withErrors($validator);
                }

                $image = $request->file('file');
                //generate thumbnaill image 
                $imagename_thubmnail = $this->generate_thumbnail_image($image);

                $input['image'] = time().'.'.$image->getClientOriginalExtension();

                $dist = public_path('/items_pics');
                
                $image->move($dist, $input['image']);
                
                $item = Item::findOrFail($id);
                $item->big_img = $input['image'];
                $item->small_img = $imagename_thubmnail;
                $item->save();

                Session::flash('item', 'Successfully Uploaded Image!');
                return redirect()->route('items.edit', $id);

            } else {
                echo $this->not_allowed();
            }
        }
        elseif($request->submit == 'Cancel')
        {
            return redirect()->route('items.edit', $id);
        }

    }


    public function upload_image($id)
    {
        return view('manage.items.upload_image')->withId($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $options = array(''=> trans('select_option'),1=> trans('items.active'), 0=> trans('items.inactive'));
        return view('manage.items.create')->withOptions($options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if($request->submit == 'Submit') {


            $validators = Validator::make($request->all(), [
                'item_title'=> ['required', 
                    function($attribute, $value, $fail) {
                        if(in_array(null, $value, true)) {
                            return $fail(trans('items.title'). ' '. trans('rule.required'));
                        }
                    },
                    new Chk_if_title_unique()
                ],
                
                'item_description' => ['required', 
                    function($attribute, $value, $fail) {
                        if(in_array(null, $value, true)) {
                            return $fail(trans('items.description'). ' '. trans('rule.required'));
                        }
                    }
                ],
                'item_price' => 'required|numeric',
                'was_price' => 'numeric',
                'status'=> 'required|numeric'
            ]);

            if($validators->fails())
            {
                return redirect()->route('items.create')->withErrors($validators)->withInput();
            }



            $item = new Item();
            $item->item_title = serialize($request->item_title);
            $item->item_description = serialize($request->item_description);
            $item->item_price = $request->item_price;
            $item->was_price = $request->was_price;
            $item->status = $request->status;

            $item->item_url = str_slug($request->item_title['en']);
            $item->item_url_ar = preg_replace('/\s+/', '-', $request->item_title['ar']);

            $item->save();
            Session::flash('item', 'Successfully Added!');
            
            return redirect()->route('items.edit', $item->id);
        } elseif($request->submit == 'Cancel') {
            return redirect()->route('items.index');
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
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $data['image_status'] = $item->big_img == null ? TRUE : FALSE;
        $data['image'] = $item->big_img;
        $options = array(''=> trans('select_option'),1=> trans('items.active'), 0=> trans('items.inactive'));
        return view('manage.items.edit')->withItem($item)->withOptions($options)->withData($data);
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
         if($request->submit == 'Submit') {


            $validators = Validator::make($request->all(), [
                'item_title'=> ['required', 
                    function($attribute, $value, $fail) {
                        if(in_array(null, $value, true)) {
                            return $fail(trans('items.title'). ' '. trans('rule.required'));
                        }
                    },
                    new Chk_if_title_unique($id)
                ],
                
                'item_description' => ['required', 
                    function($attribute, $value, $fail) {
                        if(in_array(null, $value, true)) {
                            return $fail(trans('items.description'). ' '. trans('rule.required'));
                        }
                    },
                   
                ],
                'item_price' => 'required|numeric',
                'was_price' => 'numeric',
                'status'=> 'required|numeric'
            ]);

            if($validators->fails())
            {
                return redirect()->route('items.edit', $id)->withErrors($validators)->withInput();
            }



            $item = Item::findOrFail($id);
            $item->item_title = serialize($request->item_title);
            $item->item_description = serialize($request->item_description);
            $item->item_price = $request->item_price;
            $item->was_price = $request->was_price;
            $item->status = $request->status;

            $item->item_url = str_slug($request->item_title['en']);
            $item->item_url_ar = preg_replace('/\s+/', '-', $request->item_title['ar']);

            $item->save();
            Session::flash('item', 'Successfully Updated!');
            
            return redirect()->route('items.edit', $item->id);
        } elseif($request->submit == 'Cancel') {
            return redirect()->route('items.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
