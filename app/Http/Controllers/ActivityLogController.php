<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ActivityLog;

class ActivityLogController extends Controller
{
    public function create($data){
      $activityLog = ActivityLog::create([
        'member_name' => $data['member_name'],
        'action' => $data['action'],
        'network_id' => $data['network_id'],
        'approved' => $data['approved'],
      ]);
    }

    public function read(Request $request){
      $logs = ActivityLog::orderBy('created_at','desc')->get();
      if (!empty($request->input('network_id'))) {
        $logs = $logs->where('network_id',$request->input('network_id'));
      }
      ActivityLog::where('network_id',$request->input('network_id'))->where('seen', '=', 0)->update(array('seen' => 1));
      return $logs;
    }

    public function count($network_id){
      return response()->json(ActivityLog::where('network_id',$network_id)->where('seen',0)->count());
    }
}
