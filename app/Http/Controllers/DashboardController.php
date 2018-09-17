<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
      $data['page_title'] = "Dashboard";
      $data['page_description'] = "View Summary of Data";
      $data['active'] = "dashboardNav";

      $data['profile_picture'] = "default.png";
      if (Auth::user()->type=="NET_LEAD") {
        $member = Member::find(Auth::user()->network);
        $data['profile_picture'] = $member->dp_filename;
      }

      return view("page.dashboard",$data);
    }
}
