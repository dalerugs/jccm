<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
      $data['page_title'] = "Dashboard";
      $data['page_description'] = "View Summary of Data";
      return view("page.dashboard",$data);
    }
}
