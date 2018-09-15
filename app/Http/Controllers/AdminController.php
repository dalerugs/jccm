<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class AdminController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index(){
    $data['page_title'] = "Admin";
    $data['page_description'] = "View Admin Menu";
    $data['active'] = "adminNav";
    return view("page.admin",$data);
  }

  public function manageUsers(){
    $data['page_title'] = "Manage Users";
    $data['page_description'] = "Browse Users";
    $data['active'] = "adminNav";
    return view("page.manage_users",$data);
  }

}
