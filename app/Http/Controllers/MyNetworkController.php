<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;

class MyNetworkController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('role:NET_LEAD');
  }

  public function showMyNetworkPage(){
    $data['page_title'] = "My Network";
    $data['page_description'] = "Manage My Network";
    $data['active'] = "myNetworkNav";
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.my_network",$data);
  }
}
