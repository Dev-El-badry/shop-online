<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Session;
use DB;
use Validator;
use LaravelLocalization;
use App\Http\Controllers\CategoryController;
use App\Rules\Chk_if_cat_title_unique;
use App\Models\Cat_assign;
use File;
class CategoryController extends Controller
{
    public function upload_image($update_id)
    {
        return view('manage.categories.upload_image', compact('update_id'));
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
                    return redirect()->route('upload_cat_pic', $id)->withErrors($validator);
                }

                $image = $request->file('file');

                $input['image'] = time().'.'.$image->getClientOriginalExtension();

                $dist = public_path('/categories_pics');
                
                $image->move($dist, $input['image']);
                
                $category = Category::findOrFail($id);
                $category->picture = $input['image'];
                $category->save();

                Session::flash('item', 'Successfully Uploaded Image!');
                return redirect()->route('category.edit', $id);

            } else {
                echo $this->not_allowed();
            }
        }
        elseif($request->submit == 'Cancel')
        {
            return redirect()->route('category.edit', $id);
        }

    }

    public function delete_image(Request $request)
    {
        $cat_id = $request->cat_id;
        if(is_numeric($cat_id))
        {
            $this->delete_proccess_image($cat_id);
            $category = Category::findOrFail($cat_id);
            $category->picture = null;
            $category->save();

            return 1;
        }
    }

    public function delete_proccess_image($id)
    {
        $category = Category::findOrFail($id);
        $pic_path = public_path('categories_pics/') . $category->picture;
        
        if(file_exists($pic_path))
        {
            File::delete($pic_path);
        }
    }

    private static function get_parent_title($parent_id)
    {
        if(is_numeric($parent_id))
        {
            $category = Category::where('cat_parent_id', $parent_id)->first();
            $cat_parent_title = unserialize($category->cat_title)[LaravelLocalization::getCurrentLocale()];
            return $cat_parent_title;
        }
    }

    public static function get_cat_title($update_id)
    {
        if($update_id)
        {
            $category = Category::where('id', $update_id)->get();
            foreach ($category as $row) {
                if($row->cat_parent_id ==0)
                {
                    $cat_title = unserialize($row->cat_title)[LaravelLocalization::getCurrentLocale()];
                }
                else
                {
                   
                    $cat_title = self::get_parent_title($row->cat_parent_id). trans('cat_assign.arrow') . unserialize($row->cat_title)[LaravelLocalization::getCurrentLocale()];
                }
            }

            return $cat_title;
        }
    }

    private function get_dropdown_categories()
    {
        $options[0] = 'Please Select Category';
        $categories = Category::where('cat_parent_id', '=', 0)->get();
        foreach ($categories as $row) {
            $str = '';
            foreach (LaravelLocalization::getSupportedLocales() as $key => $value) {
                $str .= ' ['.unserialize($row->cat_title)[$key].'] ' ;
            }
            $options[$row->id] = $str;

        }

        return $options;
    }

    public function sort(Request $request)
    {
        $number = (int)$request->num;
        $order = $request->order;
        $arrs = explode(',', $order);

        for ($i=0; $i < count($arrs) ; $i++) { 
            $update_id = $arrs[$i];
            $category= Category::findOrFail($update_id);
            $category->priority = $i+1;
            $category->save();
        }
      
    }

    public static function get_count_categories($parent_id)
    {
        $categories_count = Category::where('cat_parent_id', '=', $parent_id)->count();
        return $categories_count;
    }

    public static function get_sortable_list($cat_parent_id, $status) {
        $data['categories'] = Category::where('cat_parent_id', '=', $cat_parent_id)
                                    ->where('for_what', $status)
                                    ->orderBy('priority', 'asc')
                                    ->get();
        $data['this_site'] = TRUE;

        return view('manage.categories.sort_list', compact('data', 'status'))->render();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $status = null)
    {
       
        $data['row_id'] = $request->id;

        if(!is_numeric($data['row_id']))
        {
            $data['row_id'] = 0;
        }
        $data['status'] = $status;

        return view('manage.categories.index')->withData($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['options'] = $this->get_dropdown_categories();
        $data['status'] = [''=> trans('blog.please_choose'),'0'=> trans('blog.category'), '1'=> trans('blog.blog')];
        return view('manage.categories.create')->withData($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->submit == 'Cancel')
        {
            return redirect()->route('category.index', 0);
        }

        $validator = Validator::make($request->all(), [
            'cat_title.*' => 'required',
            'cat_url' => 'required|unique:categories',
            'cat_url_ar' => 'required|unique:categories',
            'for_what'=> 'required|numeric',
        ]);

        if($validator->fails())
        {
            return redirect()->route('category.create')->withErrors($validator);
        }

        $category = new Category();
        $category->cat_title = serialize($request->cat_title);

        $category->cat_url = str_slug($request->cat_title['en']);
        $category->cat_url_ar = preg_replace('/\s+/', '-', $request->cat_title['ar']);

        $category->cat_parent_id = $request->cat_parent_id;
        $category->for_what = $request->for_what;
        $category->save();

        Session::flash('item', trans('categories.msg_success'));

        return redirect()->route('category.edit', $category->id);
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
        $category = Category::findOrFail($id);
        $data['options'] = $this->get_dropdown_categories();
        $data['status'] = [''=> trans('blog.please_choose'),'0'=> trans('blog.category'), '1'=> trans('blog.blog')];
        $data['image'] = $category->picture;
        if(!empty($data['image']))
        {
            $data['image_status'] = TRUE;
        } else{
            $data['image_status'] = FALSE;
        }
        
        
        return view('manage.categories.edit')->withCategory($category)->withData($data);
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
        $for = Category::where('id', $id)->first()->for_what;
        if($request->submit == 'Cancel')
        {
            if($for == 0)
                return redirect()->route('category.index', 0);

            return redirect()->route('category.index',1);
        }

        $validator = Validator::make($request->all(), [
            'cat_title.*' =>  'required',
            'cat_url' => 'required|unique:categories,cat_url,'.$id,
            'cat_url_ar' => 'required|unique:categories,cat_url_ar,'.$id,
            'for_what'=> 'required|numeric',
           
        ]);


        if($validator->fails())
        {
            return redirect()->route('category.edit', $id)->withErrors($validator);
        }

        $category = Category::findOrFail($id);
        $category->cat_title = serialize($request->cat_title);

        $category->cat_url = str_slug($request->cat_title['en']);
        $category->cat_url_ar = preg_replace('/\s+/', '-', $request->cat_title['ar']);

        $category->cat_parent_id = $request->cat_parent_id;
        $category->for_what = $request->for_what;
        $category->save();

        Session::flash('item', trans('categories.msg_success_update'));

        return redirect()->route('category.edit', $category->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
         $for = Category::where('id', $id)->first()->for_what;
        if($request->submit == 'Yes - I want Delete Category')
        {
            $this->delete_process($id);

            if($for == 0)
                return redirect()->route('category.index', 0);

            return redirect()->route('category.index',1);
        } elseif($request->submit == 'Finished')
        {
            return redirect()->route('category.edit', $id);
        }
    }

    public function del_config($update_id) {
        if(is_numeric($update_id))
        {
            return view('manage.categories.del_config', compact('update_id'));
        }
    }

    private function delete_process($update_id)
    {   //missed delete items
        if(is_numeric($update_id))
        {
            
            Category::where('cat_parent_id', $update_id)->delete();
            Cat_assign::where('cat_id', $update_id)->delete();
            $this->delete_proccess_image($update_id);
            Category::where('id', $update_id)->delete();

        }
    }
}
