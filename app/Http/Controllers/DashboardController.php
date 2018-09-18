<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Constants;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
      $data['page_title'] = "Dashboard";
      $data['page_description'] = "Summary of Data";
      $data['active'] = "dashboardNav";
      $data['leaders'] = count(Member::leaders());
      $data['active'] = Member::where('inactive',0)->count();
      $data['inactive'] = Member::where('inactive',1)->count();
      $data['mens_network'] = $this->calculateNetworkSize('MALE');
      $data['womens_network'] = $this->calculateNetworkSize('FEMALE');

      $data['profile_picture'] = "default.png";
      if (Auth::user()->type=="NET_LEAD") {
        $member = Member::find(Auth::user()->network);
        $data['profile_picture'] = $member->dp_filename;
      }

      return view("page.dashboard",$data);
    }

    private function calculateNetworkSize($sex){
      $networks = Member::where([['level',1],['sex',$sex]])->orderBy('first_name')->get();
      foreach ($networks as $network) {
        for ($i=1;$i<=Constants::$MAX_LEVEL;$i++) {
          $network[$i] = Member::where([
              ['level',$i],
              ['sex',$sex],
              ['network_id',$network->id]
          ])->count();
        }
      }
      return $networks;
    }
}
