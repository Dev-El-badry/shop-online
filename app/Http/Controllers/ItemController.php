<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Cat_assign;
use App\Models\Item_color;
use App\Models\Item_galleries;
use App\Models\Item_size;
use App\Models\Basket;
use Validator;
use App\Rules\ArrayNotContainNullValue;
use App\Traits\SiteSettings;
use LaravelLocalization;
use App\Rules\Chk_if_title_unique;
use Session;
use Image;
use File;
use DB;
use Input;

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

    public function search(Request $request)
    {
        $query = Input::post('query');
       
            $items = DB::select("
            SELECT 
            COUNT(id) as count_id,
            items.*
            from items
            where item_title LIKE '%".$query."%'
            ");

            $output = '';
            if($items[0]->count_id >0)
            {
               foreach ($items as $row) {
                 if($row->status == 0)
                    {
                        $status =  '<small class="label label-danger">' . trans('items.inactive') . '</small>';
                    } else {
                        $status =  '<small class="label label-primary">'. trans('items.active') . '</small>';
                    }
                    $output .= "
                    <tr>
                    <td>".$row->id."</td>
                    <td>".unserialize($row->item_title)[LaravelLocalization::getCurrentLocale()]."</td>
                    <td>".$row->item_price .' '.$this->get_currency_symble() ."</td>
                    <td>".$row->was_price .' '.$this->get_currency_symble() ."</td>

                    <td>
                    ".

                    $status

                    ."
                    </td>

                    <td>". unserialize($row->item_description)[LaravelLocalization::getCurrentLocale()] ."</td>


                    <td class='pull-right'>
                     
                        <a href='".url('/items/') .$row->id . 'edit' ."' class='btn btn-default'>
                        <i class='fa fa-edit fa-fw'></i> &nbsp;
                        ".trans('items.edit')."</a>
                    </td>
                </tr>
                    ";
               }
            } else{
                $output .= "<p style='color: red; padding:10px'>".trans('items.not_found')."</p>";
            }

            echo $output;
        
    }

    // public function search(Request $request)
    // {
    //     $query = Input::post('query');
       
    //     if(!empty($query))
    //     {
    //         $slug_lang = LaravelLocalization::getCurrentLocale();
    //         if($slug_lang == 'ar')
    //         {
    //             $items = DB::select("
    //             SELECT 
    //             SUBSTRING_INDEX(SUBSTRING_INDEX(item_title,';',3),':',-1) AS fieldname2,
    //             SUBSTRING_INDEX(SUBSTRING_INDEX(item_title,';',4),':',-1) AS fieldvalue2
    //             from items
    //             where fieldvalue2 LIKE '%".$query."%'
    //             ");
    //         } elseif($slug_lang == 'en')
    //         {
    //             $items = DB::select("
    //             SELECT 
    //             SUBSTRING_INDEX(SUBSTRING_INDEX(item_title,';',1),':',-1) AS fieldname1,
    //             SUBSTRING_INDEX(SUBSTRING_INDEX(item_title,';',2),':',-1) AS fieldvalue1,
    //             from items
    //             where fieldvalue1 LIKE '%".$query."%'
    //             ");
    //         }


    //         dd($items);
    //     }
    // }

    ////////////////////////////////Upload File

    public function downloadFile(Request $request) 
    {
        $filename = $request->pdf_file;

        $file_path = public_path().'/pdf_files/'.$filename;
        $header = ['Content-Type: application/pdf'];
        $newName = 'item-information-pdf-file'.time().'.pdf';

        $res = response()->download($file_path, $newName, $header);

        if($res) 
            return 1;

        return 0;
    }

    private function delete_process_pdf($id) {
        $item = Item::findOrFail($id);
        $pdf_file = public_path('/pdf_files/').$item->pdf_file;

        if(file_exists($pdf_file)) 
        {
            
            File::delete($pdf_file);
        }
    }

    public function delete_pdf(Request $request) 
    {   
        $item_id = $request->id;

        if(is_numeric($item_id))
        {
           $this->delete_process_pdf($item_id);
           $item = Item::findOrFail($item_id);
           $item->pdf_file = null;
           $item->save();

           return 1;
        }
        else
        {
            return 0;
        }
    }

    public function fileUploadPdf(Request $request, $id) {

        if($request->submit == 'Upload')
        {
            if(is_numeric($id)) {

                $validator = validator($request->all(), [
                    'file'=> 'required|mimes:pdf|max:10000'
                ]);

                if($validator->fails())
                {
                    return redirect()->route('upload_file', $id)->withErrors($validator);
                }

                $pdf = $request->file('file');
            
                $input['pdf'] = uniqid().$pdf->getClientOriginalName().'.'.$pdf->getClientOriginalExtension();

                $dist = public_path('/pdf_files');
                
                $pdf->move($dist, $input['pdf']);
                
                $item = Item::findOrFail($id);
                $item->pdf_file = $input['pdf'];
                $item->save();

                Session::flash('item', 'Successfully Uploaded PDF!');
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


    public function upload_file($id)
    {
        return view('manage.items.upload_file')->withId($id);
    }


    ////////////////////////////////Upload Image

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
                    return redirect()->route('upload_image', $id)->withErrors($validator);
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

                Session::flash('item', trans('items.succ_img'));
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
        $options = array(''=> trans('items.select_option'),1=> trans('items.active'), 0=> trans('items.inactive'));
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
                'item_title.*'=> 'required',
                
                'item_description.*' => 'required',
                'item_price' => 'required|numeric',
                'item_url'=>'required|unique:items',
                'item_url_ar'=>'required|unique:items',
                'was_price' => 'numeric',
                'status'=> 'required|numeric',
                'item_qty'=> 'required|numeric',
                'discount'=> 'required|numeric'
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
            $item->item_qty = $request->item_qty;
            $item->discount = $request->discount;

              $item->item_url = $request->item_url;
            $item->item_url_ar = $request->item_url_ar;

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

        $item = Item::where('id', $id)->with('item_galleries')->first();
        
        //dd($item->toArray());
        $data['image_status'] = $item->big_img == null ? TRUE : FALSE;
        $data['file_status'] = $item->pdf_file == null ? TRUE : FALSE;
        $data['image'] = $item->big_img;
        $data['pdf'] = $item->pdf_file;
       
        $options = array(''=> trans('items.select_option'),1=> trans('items.active'), 0=> trans('items.inactive'));
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
                'item_title.*'=> 'required',
                 'item_url'=>'required|unique:items,item_url,'.$id,
                'item_url_ar'=>'required|unique:items,item_url_ar,'.$id,
                'item_description.*' => 'required',
                'item_price' => 'required|numeric',
                'was_price' => 'numeric',
                'status'=> 'required|numeric',
                'item_qty'=> 'required|numeric',
                'discount'=> 'required|numeric'
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

            $item->item_url = $request->item_url;
            $item->item_url_ar = $request->item_url_ar;
            $item->item_qty = $request->item_qty;
            $item->discount = $request->discount;

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
    public function destroy(Request $request, $id)
    {
        
        if($request->submit == 'Finished')
        {
            return redirect()->route('items.edit', $id);
        }

        if(is_numeric($id))
        {
            $this->delete_process_config($id);
            return redirect()->route('items.index');
        }
    }

    public function delete_config($update_id)
    {
        if(is_numeric($update_id))
        {
            return view('manage.items.delete_config', compact('update_id'));
        }
    }

    public function delete_process_galleries($id)
    {
        $item_g = Item_galleries::where('parent_id', $id)->get();
        foreach ($item_g as $row) {
             $big_img = public_path('/item_galleries/').$row->picture;
       
            if(file_exists($big_img) ) 
            {
                
                File::delete($big_img);
            }
        }
       
    }

    private function delete_process_config($id)
    {
        if(is_numeric($id))
        {
            $this->delete_process_pdf($id);
            $this->delete_process($id);
            $this->delete_process_galleries($id);
            Item_color::where('item_id', $id)->delete(); 
            Item_size::where('item_id', $id)->delete(); 
            Cat_assign::where('item_id', $id)->delete();
            Item_galleries::where('parent_id', $id)->delete();
            Basket::where('item_id', $id)->delete();
            $item = Item::where('id', $id)->delete();
        }
    }
}
