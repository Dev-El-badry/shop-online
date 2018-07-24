<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use JWTFactory;
use JWTAuth;
use Validator, DB, Hash, Mail;
use Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
    	$credentials = $request->only('name', 'email', 'password', 'phone_number');
    	$rules = [
    		'name' => 'required|max:255|unique:users',
    		'email' => 'required|email|max:255|unique:users',
    		'password' => 'required|min:6',
        'phone_number'=> 'sometimes|nullable|string|min:10|unique:users'
    	];

    	$validator = Validator::make($credentials, $rules);
    	if($validator->fails())
    	{
    		return response()->json(['success'=>false, 'errors'=> $validator->errors() ]);
    	}

    	$user = new User();
    	$user->name = $request->name;
    	$user->email = $request->email;
    	$user->password = Hash::make($request->password);
    	$user->phone_number = $request->phone_number;
    	$user->save();

    	$code = strtolower(str_random(6));
    	DB::table('user_verification')->insert(
    		['user_id'=>$user->id, 'verification_code'=>$code]
    	);

    	$email = $user->email;
    	$name = $user->name;

    	$subject = 'Please Verifiy Your Account';
    	Mail::send('auth.passwords.verify', ['name'=>$user->name, 'code'=> $code], function($mail) use ($email,$name, $subject) {
    		//$mail->from(getenv('FROM_EMAIL_ADDRESS'), 'From User/Company Name Goes Here');
    		$mail->to($email, $name);
    		$mail->subject($subject);
    	});

    	return response()->json(['success'=>true, 'message'=>'Thanks For Signing Up! Please Check Your Email To Complete Your Register']);
    }

    public function verifyUser(Request $request)
    {
    	$verification_code = strtolower($request->code);
    	$check = DB::table('user_verification')
    			->where('verification_code', $verification_code)
    			->first();

    	if(!is_null($check))
    	{
    		$user = User::find($check->user_id);

    		if($user->is_verified == 1)
    		{
    			return response()->json(['success'=> true, 'message'=> 'Account Aready Verified']);
    		}

    		$user->is_verified = 1;
    		$user->save();

    		DB::table('user_verification')->where('verification_code', $verification_code)->delete();

    		return response()->json([
    			'success'=> true,
    			'message'=> 'You have successfully verified your email address'
    		]);
    	}
    }
}
