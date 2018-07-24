<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use File, Image, Session;

class UsersController extends Controller
{
    public function index()
    {
    	$users = User::orderBy('id', 'desc')->paginate(10);
    	$users_count = User::count();
    	return view('manage.users.index', compact('users', 'users_count'));
    }

    public function view($update_id)
    {
    	$user = User::findOrFail($update_id);
    	return view('manage.users.view')->withUser($user);
    }

    public function delete_config($user_id)
    {
    	return view('manage.users.delete_config', compact('user_id'));
    }

    private function delete_picture($update_id)
    {
    	if(is_numeric($update_id))
    	{
    		$user_count = User::where('id', $update_id)->count();
    		$user_pic = User::where('id', $update_id)->first()->picture;
    		$pic_path = public_path('users_pic/') . $user_pic;
    		
    		if(file_exists($pic_path))
    		{
    			File::delete($pic_path);
    		}
    	}
    }

    public function destroy(Request $request, $update_id)
    {
    	if($request->submit == 'Finished')
        {
            return redirect()->route('users.view', $update_id);
        }

        if(is_numeric($update_id))
        {
            $this->delete_picture($update_id);
            User::findOrFail($update_id)->delete();
            Session::flash('item', trans('user.delete_blog_alert'));
            return redirect()->route('users.index');
        }
    }
}
