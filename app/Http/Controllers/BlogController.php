<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Category;
use Validator, Session;
use Image, File, DB;
use LaravelLocalization;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(10);
        return view('manage.blogs.index')->withBlogs($blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requests = $request->only('author', 'keywords', 'blog_description', 'blog_title', 'blog_content', 'blog_url', 'status');
        $rules = [
            'author'=> 'string',
            'blog_title.*'=> 'required',
            'blog_url'=> 'required|unique:blogs',
            'blog_content.*'=> 'required',
            'status'=> 'required|numeric',
        ];
        
        if($request->submit == 'Cancel')
        {
            return redirect()->route('blogs.index');
        }

        $validator = Validator::make($requests, $rules);
        if($validator->fails())
        {
            return redirect()->route('blogs.create')->withErrors($validator)->withInput();
        }

        $blog = new Blog();
        $blog->author = $request->author;
        $blog->keywords = $request->keywords;
        $blog->blog_description = $request->blog_description;
        $blog->blog_content = serialize($request->blog_content);
        $blog->blog_title = serialize($request->blog_title);
        $blog->blog_url = $request->blog_url;
        $blog->status = $request->status;
        
        $blog->save();

        Session::flash('item', trans('blog.alert_added'));
        
       return redirect()->route('blogs.edit', $blog->id);
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
        $blog = Blog::findOrFail($id);
        return view('manage.blogs.edit')->withBlog($blog);
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
        $requests = $request->only('author', 'keywords', 'blog_description', 'blog_title', 'blog_content', 'blog_url');
        $rules = [
            'author'=> 'string',
            'blog_title.*'=> 'required',
            'blog_content.*'=> 'required',
            'blog_url'=> 'required|unique:blogs,blog_url,'.$id,
        ];
        
        if($request->submit == 'Cancel')
        {
            return redirect()->route('blogs.index');
        }

        $validator = Validator::make($requests, $rules);
        if($validator->fails())
        {
            return redirect()->route('blogs.edit', $id)->withErrors($validator)->withInput();
        }

        $blog = Blog::findOrFail($id);
        $blog->author = $request->author;
        $blog->keywords = $request->keywords;
        $blog->blog_description = $request->blog_description;
        $blog->blog_content = serialize($request->blog_content);
        $blog->blog_title = serialize($request->blog_title);
        $blog->blog_url = $request->blog_url;
        $blog->status = $request->status;

        $blog->save();

        Session::flash('item', trans('blog.alert_updated'));
        
       return redirect()->route('blogs.edit', $blog->id);
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
            return redirect()->route('blogs.edit', $id);
        }

        if(is_numeric($id))
        {
            $this->delete_process($id);
            $blog = Blog::findOrFail($id)->delete();
            Session::flash('item', trans('blog.delete_blog_alert'));
            return redirect()->route('blogs.index');
        }
    }

    public function delete_config($blog_id) 
    {
        return view('manage.blogs.delete_config', compact('blog_id'));
    }

    private function delete_process($blog_id) 
    {
        $this->delete_process_image($blog_id);
    }

    public function upload_image($blog_id)
    {
        return view('manage.blogs.upload_image', compact('blog_id'));
    }

    private function generate_thumbnail_image($image, $name)
    {
        $input['imagename'] = $name.'-thubmnail.'.$image->getClientOriginalExtension();
        $dist = public_path('/blog_pics');
        $img = Image::make($image->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dist.'/'.$input['imagename']);

    }

    public function do_upload(Request $request, $id) {

        if($request->submit == 'Upload')
        {
            if(is_numeric($id)) {

                $validator = validator($request->all(), [
                    'file'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if($validator->fails())
                {
                    return redirect()->route('blogs.upload_image', $id)->withErrors($validator);
                }

                $image = $request->file('file');
                //generate thumbnaill image 
                $str = time().'_'.str_random(8);
                $this->generate_thumbnail_image($image, $str);

                $input['image'] = $str.'.'.$image->getClientOriginalExtension();

                $dist = public_path('/blog_pics');
                
                $image->move($dist, $input['image']);
                
                $blog = Blog::findOrFail($id);
                $blog->picture = $input['image'];
               
                $blog->save();

                Session::flash('item', 'Successfully Uploaded Image!');
                return redirect()->route('blogs.edit', $id);

            } else {
                echo $this->not_allowed();
            }
        }
        elseif($request->submit == 'Cancel')
        {
            return redirect()->route('items.edit', $id);
        }

    }

    public function delete_image(Request $request) 
    {   
        $blog_id = $request->id;

        if(is_numeric($blog_id))
        {
           $this->delete_process_image($blog_id);
           $blog = Blog::findOrFail($blog_id);
           $blog->picture = null;
           $blog->save();

           return 1;
        }
        else
        {
            return 0;
        }
    }

    private function delete_process_image($blog_id)
    {
        $blog = Blog::findOrFail($blog_id);
        $big_img = public_path('blog_pics/').$blog->picture;
        $small_img = public_path('blog_pics/').str_replace('.', '-thubmnail.', $blog->picture);

        if(file_exists($big_img) AND file_exists($small_img)) 
        {
            File::delete($big_img, $small_img);
        }
    }

    private function get_dropdown_options()
    {
        $categories = Category::where('for_what', 1)->get();

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

    public function get_cat_assign($update_id)
    {
                if(is_numeric($update_id))
        {
            //do something
            $options = $this->get_dropdown_options();
            
            $cats_assign = DB::table("blog_category")->where('blog_id', $update_id)->get();
            $num_rows = DB::table("blog_category")->where('blog_id', $update_id)->count();

            foreach ($cats_assign as $row) {
                $cat_id = $row->cat_id;
                $category = Category::where('id', $cat_id)->where('for_what', 1)->first();
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
            
            return view('manage.blogs.get_cat_assign', compact('options', 'update_id','cats_assign','num_rows'));
        }
    }

    public function submit_action(Request $request, $update_id)
    {
        if($request->submit == 'Finished')
        {
            return redirect()->route('blogs.edit', $update_id);
        }

        if(is_numeric($update_id))
        {
            $validator = Validator::make($request->all(), ['cat_id'=> 'required']);
            if($validator->fails())
            {
                return redirect()->route('blogs.get_cat_asign', $update_id)->withErrors($validator);
            }
            $cat_id = $request->cat_id;

            DB::table('blog_category')->insert(
                [
                'cat_id'=> $request->cat_id, 
                'blog_id'=>$update_id
                ]
                );

            Session::flash('item', trans('cat_assign.success_msg'));

            return redirect()->route('blogs.get_cat_asign', $update_id);
        }
    }

    public function delete_cat_assign(Request $request)
    {
        $update_id = $request->cat_assign_id;
        if(is_numeric($update_id))
        {
            $this->delete_process_cat_blog($update_id);
            return 1;
        }
    }

    private function delete_process_cat_blog($update_id)
    {
        if(is_numeric($update_id))
        {
            $cat_assign = DB::table('blog_category')->where('id', $update_id)->delete();
        }
    }

}
