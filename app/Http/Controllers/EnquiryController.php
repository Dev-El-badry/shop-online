<?php

namespace App\Http\Controllers;
use App\Models\Enquiries;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
class EnquiryController extends Controller
{
    public function index()
    {
    	//$enquiries = User::with('enquiries')->first();
    	$enquiries = Enquiries::orderBy('id', 'desc')->paginate(10);
    	$enquiries_count = Enquiries::count();
    	
    	return view('manage.enquiries.index', compact('enquiries_count', 'enquiries'));
    }

    public function view($update_id)
    {
    	$enquiry = Enquiries::findOrFail($update_id);
    	$this->set_opened($update_id);
    	$options = ['0'=> trans('enquiries.plz'), '1'=>trans('enquiries.start'), '2'=> trans('enquiries.tow'), '3'=> trans('enquiries.three'),'4'=> trans('enquiries.four'),'5'=>trans('enquiries.five') ];
    	return view('manage.enquiries.view')->withEnquiry($enquiry)->withOptions($options);
    }

    private function set_opened($update_id)
    {
    	$e = Enquiries::findOrFail($update_id);
    	$e->opened = 1;
  		$e->save();
    }

    public function submitted_comment(Request $request, $update_id)
    {

    }

    public function submitted_ranking(Request $request, $update_id)
    {
    	$e = Enquiries::findOrFail($update_id);
    	$e->ranking = $request->ranking;
    	$e->save();

    	Session::flash('item', 'Successfully Update Ranking');
    	return redirect()->route('enquiries.view', $update_id);
    }
}
