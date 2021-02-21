<?php

namespace App\Http\Controllers\Helpers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait Admins
{

    // Admin Login
    public function admin_login( Request $request ){
        return view('admin.login');
    }

    // Admin Login  - Post
    public function admin_auth( Request $request ){

        // Inputs
        $username = $request->username;
        $input_password = $request->password;

        // Find User By Email
        $selectUser = Admin::where('username',$username)->first();
        if( isset($selectUser->password) ){
            if( Hash::check( $input_password, $selectUser->password )){

                if($selectUser->level="M"){
                    session()->put('master_logged',$selectUser->id);
                }

                session()->put('admin_username',$selectUser->nickname);
                session()->put('admin_id',$selectUser->id);
                return redirect('/');
            }else{
                return redirect()->back()->withErrors('Auth Failed');
            }
        }else{
            return redirect()->back()->withErrors('Auth Failed');
        }
    }


}
