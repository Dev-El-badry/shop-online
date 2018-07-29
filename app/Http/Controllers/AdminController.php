<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Validator, Session, Hash;

class AdminController extends Controller
{
    public function view($update_id)
    {
        $admin = Admin::findOrFail($update_id);
        return view('manage.admins.view')->withAdmin($admin);
    }

    public function update($update_id)
    {
        $admin = Admin::findOrFail($update_id);
        return view('manage.admins.update', compact('admin', 'update_id'));
    }

    public function update_admin(Request $request, $update_id)
    {
        if($request->submit == 'Submit')
        {
            $validator = Validator::make($request->all(), [
                'name'=>'required|min:3',
                'email'=> 'required|email',
                'job_title'=> 'required|min:3'
            ]);

            if($validator->fails())
            {
                return redirect()->route('admins.update', $update_id)->withErrors($validator);
            }

            $admin = Admin::findOrFail($update_id);
            $admin->name = $request->name;
            $admin->email = $request->email;
            $admin->job_title = $request->job_title;
            $admin->save();

            Session::flash('item', trans('admins.alert_success'));
            return redirect()->route('admins.update', $update_id);
        }
    }

    public function update_password($update_id)
    {
        return view('manage.admins.update_password', compact('update_id'));
    }

    public function submit_password(Request $request, $update_id)
    {
        if($request->submit == 'Submit')
        {    
            $validator = Validator::make($request->all(), [
                'password'=>'required|confirmed|min:6',
                
            ]);

            if($validator->fails())
            {
                return redirect()->route('admins.update_password', $update_id)->withErrors($validator);
            }

            $admin = Admin::findOrFail($update_id);
            $admin->password = Hash::make($request->password);
            $admin->save();

            Session::flash('item', trans('admins.alert_success_password'));
            return redirect()->route('admins.update_password', $update_id);
        } elseif($request->submit == 'Cancel')
        {
             return redirect()->route('admins.update', $update_id);
        }
    }
}
