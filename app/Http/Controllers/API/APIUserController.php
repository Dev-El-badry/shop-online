<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Hash, Image, File;
use App\Models\User;

class APIUserController extends Controller
{
    public function add_details(Request $request, $user_id)
    {

    	$requests = $request->only('name', 'firstname', 'lastname', 'email', 'phone_number', 'address1', 'address2', 'country', 'town');
    	
    	$rules = [
    		'name'=> 'required|string|min:3|unique:users,name,'.$user_id,
    		'firstname'=> 'sometimes|nullable|string|min:3',
    		'lastname'=> 'sometimes|nullable|string|min:3',
    		'email'=> 'required|email|unique:users,email,'.$user_id,
    		'phone_number'=> 'sometimes|nullable|string|unique:users,phone_number,'.$user_id,
    		'address1'=> 'sometimes|nullable|string|min:3',
    		'address2'=> 'sometimes|nullable|string|min:3',
    		'country'=> 'sometimes|nullable|string|min:3',
    		'town'=> 'sometimes|nullable|string|min:3',

    	];
    	$validator = Validator::make($requests, $rules);
    	if($validator->fails())
    	{
    		return response()->json(['success'=>false, 'errors'=> $validator->errors()], 401);
    	}

    	try {
    	
    	$user = User::findOrFail($user_id);
    	$user->name = $request->name;
    	$user->firstname = $request->firstname;
    	$user->lastname = $request->lastname;
    	$user->email = $request->email;
    	$user->phone_number = $request->phone_number;
    	$user->address1 = $request->address1;
    	$user->address2 = $request->address2;
    	$user->country = $request->country;
    	$user->town = $request->town;
    	$user->save();

    	return response()->json(['success'=>true, 'message'=> 'Successfully Update Info User'], 200);

    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'errors'=> $e->getMessage()], 500);
    	}


    }

    public function update_passwords(Request $request, $user_id)
    {
    	$requests = $request->only('password', 'password_confirmation');
    	$rules = [
    		'password'=> 'required|confirmed|min:6',
    	];

    	$validator = Validator::make($requests, $rules);
    	if($validator->fails())
    	{
    		return response()->json(['success'=>false, 'errors'=> $validator->errors()], 401);
    	}

    	try {
    	
    	$user = User::findOrFail($user_id);
    	$user->password = Hash::make($request->password);
    	$user->save();

    	return response()->json(['success'=>true, 'message'=> 'Successfully Update password User'], 200);

    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'errors'=> $e->getMessage()], 500);
    	}
    }

    public function do_upload(Request $request, $user_id)
    {
    	$validator = validator($request->all(), [
            'file'=> 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($validator->fails())
        {
            return response()->json(['success'=>false, 'errors'=> $validator->errors()], 401);
        }

        $image = $request->file('file');
        //generate thumbnaill image 
        $str = time().'_'.str_random(8);

        $input['image'] = $str.'.'.$image->getClientOriginalExtension();

        $dist = public_path('/users_pic');
        
        $image->move($dist, $input['image']);
        try {
    	$this->delete_process($user_id);
    	$user = User::findOrFail($user_id);
    	$user->picture = $input['image'];
    	$user->save();

    	return response()->json(['success'=>true, 'message'=> 'Successfully Update picture User'], 200);

    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'errors'=> $e->getMessage()], 500);
    	}
    }

    private function delete_process($user_id)
    {
    	$image = User::find($user_id)->first()->picture;
    	$image_path = public_path('users_pic') . '/'.$image;
    	if(file_exists($image_path))
    	{
    		File::delete($image_path);
    	}
    }
}
