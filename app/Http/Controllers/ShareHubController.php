<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareHubController extends Controller
{
    public function showShareHubLanding(){
      $data = array();
      $data['page_title'] = "ShareHub";
      return view("page.share_hub_home",$data);
    }
}
