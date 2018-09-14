<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin(){
      $data['page_title'] = "Login";
      return view("page.login",$data);
    }

    public function doLogin(){

    }

    public function doLogout(){

    }
}
