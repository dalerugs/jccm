<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Batch;
use App\Member;
use Illuminate\Support\Facades\Event;


class AdminController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
      $this->middleware('role:ADMIN');
  }

  public function index(){
    $data['page_title'] = "Admin";
    $data['page_description'] = "View Admin Menu";
    $data['active'] = "adminNav";
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.admin",$data);
  }

  public function manageUsers(){
    $data['page_title'] = "Manage Users";
    $data['page_description'] = "Browse Users";
    $data['active'] = "adminNav";
    $data['networks'] = Member::where('level',1)->orderBy('first_name')->get();
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.manage_users",$data);
  }

  public function manageMembers(){
    $data['page_title'] = "Manage Members";
    $data['page_description'] = "Browse Members";
    $data['active'] = "adminNav";
    $data['batches'] = Batch::orderBy('no')->get();
    $data['networks'] = Member::where('level',1)->orderBy('first_name')->get();
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.manage_members",$data);
  }

  public function manageBatch(){
    $data['page_title'] = "Manage Batch";
    $data['page_description'] = "Browse Batch";
    $data['active'] = "adminNav";
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.manage_batch",$data);
  }

  public function manageFiles(){
    $data['page_title'] = "Manage Files";
    $data['page_description'] = "Browse Files";
    $data['active'] = "adminNav";
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.manage_files",$data);
  }

}
