<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
      $data['page_title'] = "Dashboard";
      $data['page_description'] = "View Summary of Data";
      return view("page.dashboard",$data);
    }
}
