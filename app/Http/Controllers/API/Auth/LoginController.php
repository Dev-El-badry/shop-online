<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
    	$credentials = $request->only('email', 'password');

    	$rules = [
    		'email' =>'required|email',
    		'password' => 'required|min:6'
    	];

    	$validator = Validator::make($credentials, $rules);
    	if($validator->fails())
    	{
    		return response()->json(['success'=> true, 'errors'=> $validator->errors()], 401);
    	}

    	$credentials['is_verified'] =1;
    	
    	
    	try {
    		if(! $token = JWTAuth::attempt($credentials))
    		{
    			return response()->json(['success'=>false, 'error' =>'We can\'t find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'], 404);
    		}
    	} catch(JWTException $e) {
    		return response()->json(['success'=> false, 'error'=> 'Failed to login, please try again.'], 401);
    	}

    	$user = User::where('email', $request->email)->first();


    	return response()->json(['success'=> true, 'data'=> ['token'=>$token, 'result'=> $user->toArray()]], 200);
    }

    public function logout(Request $request)
    {
    	$this->validate($request, ['token'=> 'required']);

    	try {
    		JWTAuth::invalidate($request->input('token'));
    		return response()->json(['success'=> true, 'error'=> 'you have successfully logged out']);
    	} catch (Exception $e) {
    		return response()->json(['success'=>false, 'error'=> 'faild to logout, please try again']);
    	}
    }
}
