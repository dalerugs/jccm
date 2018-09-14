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

    public function doLogin(Request $request){
      if (Auth::attempt($request->only('username', 'password'))) {
          return redirect()->route('dashboard');
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
