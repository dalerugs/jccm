<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Batch;

class MyNetworkController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('role:NET_LEAD');
  }

  public function showMyNetworkMenu(){
    $data['page_title'] = "My Network";
    $data['page_description'] = "View My Network Menu";
    $data['active'] = "myNetworkNav";
    $data['user'] = Member::find(Auth::user()->network);
    $data['profile_picture'] = $data['user']->dp_filename;
    return view("page.my_network",$data);
  }

  public function manageMembers(){
    $data['page_title'] = "Manage Members";
    $data['page_description'] = "Browse My Members";
    $data['active'] = "myNetworkNav";
    $data['batches'] = Batch::orderBy('no')->get();
    $data['networks'] = Member::where('level',1)->orderBy('first_name')->get();
    $data['user'] = Member::find(Auth::user()->network);
    $data['profile_picture'] = $data['user']->dp_filename;
    return view("page.manage_members_network",$data);
  }

  public function manageRequests(){
    $data['page_title'] = "Manage Requests";
    $data['page_description'] = "Browse My Requests";
    $data['active'] = "myNetworkNav";
    $data['batches'] = Batch::orderBy('no')->get();
    $data['networks'] = Member::where('level',1)->orderBy('first_name')->get();
    $data['user'] = Member::find(Auth::user()->network);
    $data['profile_picture'] = $data['user']->dp_filename;
    return view("page.manage_requests_network",$data);
  }
}
