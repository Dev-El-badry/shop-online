<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\Enquiries;

class APIEnquiriesController extends Controller
{
    public function submit_message(Request $request)
    {
    	$requests = $request->only('sent_to', 'sent_by', 'subject', 'message',  'urgent');
    	$rules = [
    		'sent_to'=> 'required|numeric',
    		'sent_by'=> 'required|numeric',
    		'subject'=> 'required|string|min:2',
    		'message'=> 'required|string',
    		
    		'urgent'=> 'required|numeric'
    	];

    	$validator = Validator::make($requests, $rules);
    	if($validator->fails())
    	{
    		return response()->json(['success'=> false, 'errors'=>$validator->error()], 401);
    	}

    	try {
    	
    	$enquiry = new Enquiries();
    	$enquiry->sent_to = $request->sent_to;
    	$enquiry->sent_by = $request->sent_by;
    	$enquiry->subject = $request->subject;
    	$enquiry->message = $request->message;
    	$enquiry->code = str_random(6);
    	$enquiry->urgent = $request->urgent;
    	$enquiry->save();

    	return response()->json(['success'=>true, 'message'=> 'Successfully Send Message'], 200);

    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'errors'=> $e->getMessage()], 500);
    	}
    }
}
