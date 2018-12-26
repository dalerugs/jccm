<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function showLogin(){
      $this->middleware('guest');
      $data['page_title'] = "Login";
      return view("page.login",$data);
    }

    public function showChangePassword(){
      $data['page_title'] = "Change Password";
      return view("page.change_password",$data);
    }

    public function doLogin(Request $request){
      if (Auth::attempt($request->only('username', 'password'))) {
        if (Auth::user()->change_password==1) {
          return redirect()->route('changePassword');
        }else {
          return redirect()->route('dashboard');
        }
      }
      else {
          return back()->withErrors(['msg', 'Invalid username or password.']);
      }
    }

    public function doLogout(){
      Auth::logout();
  		return redirect()->route('login');
    }
}
