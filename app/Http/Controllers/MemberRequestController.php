<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Training;
use App\MemberRequest;
use App\TrainingRequest;
use Validator;

class MemberRequestController extends Controller
{

  public function create(Request $request){
      $validator = Validator::make($request->all(), [
          'first_name' => 'required',
          'last_name' => 'required',
          'sex' => 'required',
          'birth_date' => 'required',
          'address' => 'required',
          'level' => 'required',
      ]);
      if ($validator->passes()) {
        if($request->input('id') && !(MemberRequest::where('member',$request->input('id'))->first())){
          $filename = "default.png";
          if($request->hasFile('picture')) {
             $file = $request->file('picture');
             $filename = str_random(60).'.'.$file->getClientOriginalExtension();
             $file->move(public_path().'/dp/', $filename);
          }
          if ($request->input('level')==2) {
            $leader_id = $request->input('network_id');
          }else if ($request->input('level')>2) {
            $leader_id = $request->input('leader_id');
          }else {
            $leader_id = 0;
          }
          $member = MemberRequest::create([
              'member' => $request->input('id'),
              'first_name' => $request->input('first_name'),
              'last_name' => $request->input('last_name'),
              'birth_date' => $request->input('birth_date'),
              'sex' => $request->input('sex'),
              'address' => $request->input('address'),
              'level' => $request->input('level'),
              'network_id' => empty($request->input('network_id'))?0:$request->input('network_id'),
              'leader_id' => $leader_id,
              'dp_filename' => $filename,
              'action' => $request->input('action'),
          ]);
          if ($request->input('level')==1) {
            $member->network_id = $member->id;
            $member->save();
          }

          $member->leader_code = $this->generateLeaderCode($member);
          $member->save();

          TrainingRequest::create([
              'member'=> $member->id,
              'batch'=> empty($request->input('batch'))?0:$request->input('batch'),
              'pre_encounter'=> $request->input('pre_encounter'),
              'encounter'=> $request->input('encounter'),
              'post_encounter'=> $request->input('post_encounter'),
              'sol1'=> $request->input('sol1'),
              'sol2'=> $request->input('sol2'),
              're_encounter'=> $request->input('re_encounter'),
              'sol3' => $request->input('sol3'),
              'baptism' => empty($request->input('baptism'))?"":$request->input('baptism'),
          ]);
          return response()->json([
            'success'=> true,
          ]);
        }
        else {
          return response()->json([
                'success'=> false,
                'duplicate'=> true,
                'errors'=>['Duplicate']
                ]);
        }
      }
      else {
        return response()->json([
              'success'=> false,
              'duplicate'=> false,
              'errors'=>$validator->errors()->all()
              ]);
      }
  }

  public function read(){
    $data['members'] = MemberRequest::orderBy('first_name')->get();
    foreach ($data['members'] as $member) {
      $member['network_leader'] = "N/A";
      $member['leader'] = "N/A";
      if ($member->network_id > 0 && $member->level > 1) {
        $network_leader = Member::find($member->network_id);
        $member['network_leader'] = $network_leader->first_name." ".$network_leader->last_name;
      }
      if ($member->leader_id > 0) {
        $leader = Member::find($member->leader_id);
        $member['leader'] = $leader->first_name." ".$leader->last_name;
      }
      $member['training'] = TrainingRequest::where('member', $member->id)->first();
      $member['batch_name'] = "N/A";
      if ($member['training']->batch) {
        $batch = Batch::where('id', $member['training']->batch)->first();
        $member['batch_name'] = $batch['no']." - ".$batch['name'];
      }
      $member['formatted_birth_date']=date("F d, Y", strtotime($member->birth_date));
      $member['age'] = Carbon::parse($member->birth_date)->age;
    }
    return $data;
  }

  public function readWithFilter(Request $request){
    $members = MemberRequest::orderBy('first_name')->get();

    if (!empty($request->input('sex'))) {
      $members = $members->where('sex',$request->input('sex'));
    }

    if (!empty($request->input('level'))) {
      $members = $members->where('level',$request->input('level'));
    }

    if (!empty($request->input('leader_id'))) {
      $members = $members->where('leader_id',$request->input('leader_id'));
    }

    if (!empty($request->input('network_id'))) {
      $members = $members->where('network_id',$request->input('network_id'));
    }

    if ($request->input('inactive') != "") {
      $members = $members->where('inactive',$request->input('inactive'));
    }

    if (!empty($request->input('action'))) {
      $members = $members->where('action',$request->input('action'));
    }


    foreach ($members as $member) {
      $member['network_leader'] = "N/A";
      $member['leader'] = "N/A";
      if ($member->network_id > 0 && $member->level > 1) {
        $network_leader = Member::find($member->network_id);
        $member['network_leader'] = $network_leader->first_name." ".$network_leader->last_name;
      }
      if ($member->leader_id > 0) {
        $leader = Member::find($member->leader_id);
        $member['leader'] = $leader->first_name." ".$leader->last_name;
      }
      $member['training'] = TrainingRequest::where('member', $member->id)->first();
      $member['batch_name'] = "N/A";
      if ($member['training']->batch) {
        $batch = Batch::where('id', $member['training']->batch)->first();
        $member['batch_name'] = $batch['no']." - ".$batch['name'];
      }
      $member['formatted_birth_date']=date("F d, Y", strtotime($member->birth_date));
      $member['age'] = Carbon::parse($member->birth_date)->age;
    }
    $data['members'] = $members;
    return $data;
  }

  public function show($id)
  {
      $member = MemberRequest::find($id);
      $member['network_leader'] = "N/A";
      $member['leader'] = "N/A";
      if ($member->network_id > 0 && $member->level > 1) {
        $network_leader = Member::find($member->network_id);
        $member['network_leader'] = $network_leader->first_name." ".$network_leader->last_name;
      }
      if ($member->leader_id > 0) {
        $leader = Member::find($member->leader_id);
        $member['leader'] = $leader->first_name." ".$leader->last_name;
      }
      $member['training'] = TrainingRequest::where('member', $member->id)->first();
      $member['batch_name'] = "N/A";
      if ($member['training']->batch) {
        $batch = Batch::where('id', $member['training']->batch)->first();
        $member['batch_name'] = $batch['no']." - ".$batch['name'];
      }
      $member['formatted_birth_date']=date("F d, Y", strtotime($member->birth_date));
      $member['age'] = Carbon::parse($member->birth_date)->age;
      return $member;
  }

  public function approvedRequest($id){
    $member = Member ::findOrFail($id);
    $member->approved=1;
    $member->save();
    return 204;
  }

  public function delete($id)
  {
      $member = Member ::findOrFail($id);
      $training = Training::where('member', $member->id)->first();
      $training->delete();
      if ($member->dp_filename != "default.png") {
        unlink(public_path().'/dp/'.$member->dp_filename);
      }
      $member->delete();
      return 204;
  }

  private function generateLeaderCode($member){
    $leader_code = $member->id;
    if($member->level > 1){
      $leader_code = $member->leader_id."-".$member->id;
      $last_leader_id = $member->leader_id;
      for ($i=($member->level - 1); $i > 1 ; $i--) {
        $next_leader = Member::find($last_leader_id);
        $last_leader_id = $next_leader->leader_id;
        $leader_code = $last_leader_id."-".$leader_code;
      }
    }
    return $leader_code;
  }
}