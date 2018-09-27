<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\Training;
use App\Batch;
use App\Constants;

class PepsolReportController extends Controller
{
  public function index(){
    $this->middleware('auth');
    $data['page_title'] = "PEPSOL Report";
    $data['page_description'] = "View PEPSOL Report";
    $data['active'] = "pepsolNav";
    $data['networks'] = Member::where('level',1)->orderBy('first_name')->get();

    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }

    $data['all_pepsol'] = $this->calculatePepsolReport();

    return view("page.pepsol",$data);
  }

  public function calculatePepsolReport(){
    $batches = Batch::orderBy('no')->get();
    $total = Constants::$TRAININGS_TOTAL;
    foreach ($batches as $batch) {
      foreach (Constants::$TRAININGS as $key => $column ) {
        $count = Training::where([
            ['batch',$batch->id],
            [$column,1],
        ])->count();
        $batch[$key] = $count;
        $total[$key] += $count;
      }
      $batch['total'] = round($batch['PRE']==0?0:($batch['SOL3']/$batch['PRE'])*100);
    }
    $total['total'] = round($total['PRE']==0?0:($total['SOL3']/$total['PRE'])*100);
    $data['report'] = $batches;
    $data['total'] = $total;
    return $data;
  }

  public function calculateNetworkPepsolReport($network_id){
    $batches = Batch::orderBy('no')->get();
    $total = Constants::$TRAININGS_TOTAL;
    foreach ($batches as $batch) {

      foreach (Constants::$TRAININGS as $key => $column ) {
        $count = Member::join('trainings', 'members.id', '=', 'trainings.member')->where([
          ['members.network_id',$network_id],
          ['trainings.batch',$batch->id],
          ['trainings.'.$column,1]
          ])->count();
        $batch[$key] = $count;
        $total[$key] += $count;
      }
      $batch['total'] = round($batch['PRE']==0?0:($batch['SOL3']/$batch['PRE'])*100);
    }
    $total['total'] = round($total['PRE']==0?0:($total['SOL3']/$total['PRE'])*100);
    $data['report'] = $batches;
    $data['total'] = $total;
    $data['members'] = Member::join('trainings', 'members.id', '=', 'trainings.member')
    ->join('batches', 'trainings.batch', '=', 'batches.id')
    ->where('members.network_id',$network_id)->get();
    foreach ($data['members'] as $member) {
      $member['leader'] = "N/A";
      if ($member->leader_id > 0) {
        $leader = Member::find($member->leader_id);
        $member['leader'] = $leader->first_name." ".$leader->last_name;
      }
    }
    $data['leaders'] = Member::leaders($network_id);
    return $data;
  }
}
