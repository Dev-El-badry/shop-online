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

class RecoverPasswordController extends Controller
{
    public function recover(Request $request) 
    {

    	$user = User::where('email', $request->email)->first();
    	if(!$user)
    	{
    		$error_msg = 'your email address not found';
    		return response()->json(['seccess'=> false, ['error'=> $error_msg]], 401);
    	}

    	try {
    		Password::sendResetLink($request->only('email'), function (Message $message) {
    			$message->subject('Your Password Reset Link');
    		});
    	} catch (\Exception $e) {
    		//Return error
    		$error_msg = $e->getMessage();
    		return response()->json(['success'=>false, 'error'=> $error_msg], 401);
    	}

    	return response()->json([
    		'success'=> true, 'data'=> ['message'=> 'A reset Email has been sent! please check your email']
    	]);
    }
}
