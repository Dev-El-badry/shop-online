<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Homepage_Block;
use App\Models\Homepage_Offer;
use Session;
class HomepageBlock extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['row_id'] = $request->id;

        if(!is_numeric($data['row_id']))
        {
            $data['row_id'] = 0;
        }

        return view('manage.homepage_blocks.index')->withData($data);
    }

    public function sort(Request $request)
    {
        $number = (int)$request->num;
        $order = $request->order;
        $arrs = explode(',', $order);

        for ($i=0; $i < count($arrs) ; $i++) { 
            $update_id = $arrs[$i];
            $block= Homepage_Block::findOrFail($update_id);
            $block->priority = $i+1;
            $block->save();
        }
      
    }

    public static function get_count_blocks($parent_id)
    {
        $blocks_count = Homepage_Block::count();
        return $blocks_count;
    }

    public static function get_sortable_list() {
        $data['blocks'] = Homepage_Block::orderBy('priority', 'asc')
                                    ->get();
        $data['this_site'] = TRUE;

        return view('manage.homepage_blocks.sort_list', compact('data'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.homepage_blocks.create');
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
            return redirect()->route('homepage_blocks.index');
        }

        $requests = $request->only('block_title');
        $rule = ['block_title.*'=> 'required'];
        $validator = Validator::make($requests, $rule);

        if($validator->fails())
        {
            return redirect()->route('homepage_blocks.create')->withErrors($validator)->withInput();
        }



        $homepage_block = new Homepage_Block();
        $homepage_block->block_title = serialize($request->block_title);
        $homepage_block->priority = 0;
        $homepage_block->save();

        Session::flash('items', trans('blocks.alert_added'));
        return redirect()->route('homepage_blocks.edit', $homepage_block->id);
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
        $homepage_block = Homepage_Block::findOrFail($id);
        return view('manage.homepage_blocks.edit', compact('homepage_block'));
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

        if($request->submit == 'Cancel')
        {
            return redirect()->route('homepage_blocks.index');
        }

        $requests = $request->only('block_title');
        $rule = ['block_title.*'=> 'required'];
        $validator = Validator::make($requests, $rule);

        if($validator->fails())
        {
            return redirect()->route('homepage_blocks.edit', $id)->withErrors($validator)->withInput();
        }

        $homepage_block = Homepage_Block::findOrFail($id);
        $homepage_block->block_title = serialize($request->block_title);
        $homepage_block->save();

        Session::flash('item', trans('blocks.alert_updated'));
        return redirect()->route('homepage_blocks.edit', $homepage_block->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->submit == 'Yes - I want Delete Block')
        {   
            $this->delete_process($id);
            Session::flash('item', trans('blocks.alert_del'));
            return redirect()->route('homepage_blocks.index');
        } elseif($request->submit == 'Finished') {
            return redirect()->route('homepage_blocks.edit', $id);
        }
    }

    public function delete_config($id)
    {
        return view('manage.homepage_blocks.delete_config', compact('id'));
    }

    private function delete_process($id)
    {
        Homepage_Offer::where('block_id', $id)->delete();
        Homepage_Block::findOrFail($id)->delete();
    }
}
