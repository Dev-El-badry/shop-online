<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Webpage;
use Validator, Session;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $webpages = Webpage::orderBy('id', 'asc')->paginate(10);
        return view('manage.cms.index')->withWebpages($webpages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.cms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requests = $request->only('page_title', 'page_keywords', 'page_description', 'page_content', 'page_url');
        $rules = [
            'page_title.*' => 'required',
            'page_url'=>'required|unique:webpages',
            'page_content.*' => 'required'
        ];

        if($request->submit == 'Cancel')
        {
            return redirect()->route('web_pages.index');
        }
        

        $validator = Validator::make($requests, $rules);
        if($validator->fails())
        {
            return redirect()->route('web_pages.create')->withErrors($validator)->withInput();
        }

        $webpage = new Webpage();
        $webpage->page_title = serialize($request->page_title);
        $webpage->page_url = $request->page_url;
        $webpage->page_keywords = $request->page_keywords;
        $webpage->page_description = $request->page_description;
        $webpage->page_content = serialize($request->page_content);

        $webpage->save();
        Session::flash('item', trans('cms.alert_added'));

        return redirect()->route('web_pages.edit', $webpage->id);
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
        $webpage = Webpage::findOrFail($id);
        return view('manage.cms.edit')->withWebpage($webpage);
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
        $requests = $request->only('page_title', 'page_keywords', 'page_description', 'page_content', 'page_url');
        $rules = [
            'page_title.*' => 'required',
            'page_url'=> 'required|unique:webpages,page_url,'.$id,
            'page_content.*' => 'required'
        ];

        if($request->submit == 'Cancel')
        {
            return redirect()->route('web_pages.index');
        }

        $validator = Validator::make($requests, $rules);
        if($validator->fails())
        {
            return redirect()->route('web_pages.edit', $id)->withErrors($validator);
        }

        $webpage = Webpage::findOrFail($id);
        $webpage->page_title = serialize($request->page_title);
        $webpage->page_url = $request->page_url;
        $webpage->page_keywords = $request->page_keywords;
        $webpage->page_description = $request->page_description;
        $webpage->page_content = serialize($request->page_content);

        $webpage->save();
        Session::flash('item', trans('cms.alert_updated'));

        return redirect()->route('web_pages.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($id>3)
        {
            if($request->submit == 'Yes - I want Delete Page')
            {
                Webpage::findOrFail($id)->delete();
                Session::flash('item', 'Successfully Delete Page');
                return redirect()->route('web_pages.index');
            } elseif ($request->submit == 'Finished') {
                return redirect()->route('web_pages.edit', $id);
            }
        }
    }

    public function deletePage($id)
    {
        if(is_numeric($id) AND $id >3)
        {
            return view('manage.cms.delete_config')->withId($id);
        }
    }
}
