<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Training;
use App\Batch;
use Validator;
use Carbon\Carbon;
use Auth;

class MemberController extends Controller
{

  public function showMembersPage(){
    $this->middleware('auth');
    $data['page_title'] = "Members";
    $data['page_description'] = "Browse Members";
    $data['active'] = "membersNav";
    $data['networks'] = Member::where('level',1)->orderBy('first_name')->get();
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.members",$data);
  }

  public function create(Request $request){

      if ($request->input('level')==1 || empty($request->input('level'))) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'birth_date' => 'required|before:10 years ago',
            'address' => 'required',
            'level' => 'required',
            'batch'=> 'required',
            'pre_encounter'=> 'numeric|min:1',
            'encounter'=> 'numeric|min:1',
            'post_encounter'=> 'numeric|min:1',
            'sol1'=> 'numeric|min:1',
            'sol2'=> 'numeric|min:1',
            're_encounter'=> 'numeric|min:1',
            'sol3' => 'numeric|min:1',
            'baptism' => 'required',
        ],
        [
          'before' => 'Age must be at least 10 years old.',
          'pre_encounter.min' => 'The pre-encounter field is required.',
          'encounter.min' => 'The encounter field is required.',
          'post_encounter.min' => 'The post encounter field is required.',
          'sol1.min' => 'The SOL 1 field is required.',
          'sol2.min' => 'The SOL 2 field is required.',
          're_encounter.min' => 'The re-encounter field is required.',
          'sol3.min' => 'The SOL 3 field is required.',
        ]);
      }else if($request->input('level')==2) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'birth_date' => 'required|before:10 years ago',
            'address' => 'required',
            'level' => 'required',
            'network_id' => 'required'
        ],
        [
          'required' => 'The :attribute field is required.',
          'network_id.required' => 'The network leader field is required.',
          'before' => 'Age must be at least 10 years old'
        ]);
      }else if($request->input('level')>2){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'birth_date' => 'required|before:10 years ago',
            'address' => 'required',
            'level' => 'required',
            'network_id' => 'required',
            'leader_id' => 'required'
        ],
        [
          'required' => 'The :attribute field is required.',
          'leader_id.required' => 'The leader field is required.',
          'before' => 'Age must be at least 10 years old'
        ]);
      }

      if ($validator->passes()) {
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
        $member = Member::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birth_date' => $request->input('birth_date'),
            'sex' => $request->input('sex'),
            'address' => $request->input('address'),
            'level' => $request->input('level'),
            'network_id' => empty($request->input('network_id'))?0:$request->input('network_id'),
            'leader_id' => $leader_id,
            'dp_filename' => $filename,
        ]);
        if ($request->input('level')==1) {
          $member->network_id = $member->id;
          $member->save();
        }

        $member->leader_code = $this->generateLeaderCode($member);
        $member->save();


        Training::create([
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
              'errors'=>$validator->errors()->all()
              ]);
      }
  }

  public function read(){
    $data['members'] = Member::orderBy('first_name')->get();
    $data['leaders'] = Member::leaders();
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
      $member['training'] = Training::where('member', $member->id)->first();
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

  public function test(){
    return Member::orderBy('first_name')->get();
  }

  public function readWithFilter(Request $request){
    $data['members_all'] = Member::orderBy('first_name')->get();
    $data['leaders'] = Member::leaders($request->input('networkId'));
    $members = Member::orderBy('first_name')->get();

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
      $member['training'] = Training::where('member', $member->id)->first();
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
      $member = Member::find($id);
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
      $member['training'] = Training::where('member', $member->id)->first();
      $member['batch_name'] = "N/A";
      if ($member['training']->batch) {
        $batch = Batch::where('id', $member['training']->batch)->first();
        $member['batch_name'] = $batch['no']." - ".$batch['name'];
      }
      $member['formatted_birth_date']=date("F d, Y", strtotime($member->birth_date));
      $member['age'] = Carbon::parse($member->birth_date)->age;
      return $member;
  }

  public function update(Request $request)
  {
      $member = Member::findOrFail($request->input('id'));
      $old_level = $member->level;
      $old_leader_id = $member->leader_id;
      $old_network_id = $member->network_id;

      $training = Training::where('member', $member->id)->first();

      if ($request->input('level')==1 || empty($request->input('level'))) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'birth_date' => 'required|before:10 years ago',
            'address' => 'required',
            'level' => 'required',
        ],
        [
          'before' => 'Age must be at least 10 years old'
        ]);
      }else if($request->input('level')==2) {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'birth_date' => 'required|before:10 years ago',
            'address' => 'required',
            'level' => 'required',
            'network_id' => 'required'
        ],
        [
          'required' => 'The :attribute field is required.',
          'network_id.required' => 'The network leader field is required.',
          'before' => 'Age must be at least 10 years old'
        ]);
      }else if($request->input('level')>2){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'birth_date' => 'required|before:10 years ago',
            'address' => 'required',
            'level' => 'required',
            'network_id' => 'required',
            'leader_id' => 'required'
        ],
        [
          'required' => 'The :attribute field is required.',
          'leader_id.required' => 'The leader field is required.',
          'before' => 'Age must be at least 10 years old'
        ]);
      }


      if ($validator->passes()) {
          if ($request->input('level')==2) {
            $leader_id = $request->input('network_id');
          }else if ($request->input('level')>2) {
            $leader_id = $request->input('leader_id');
          }else {
            $leader_id = 0;
          }
          $member->update([
              'first_name' => $request->input('first_name'),
              'last_name' => $request->input('last_name'),
              'birth_date' => $request->input('birth_date'),
              'sex' => $request->input('sex'),
              'address' => $request->input('address'),
              'level' => $request->input('level'),
              'network_id' => empty($request->input('network_id'))?0:$request->input('network_id'),
              'leader_id' => $leader_id,
          ]);
          if ($request->input('level')==1) {
            $member->network_id = $member->id;
            $member->save();
          }

          if ($member->level != $old_level ||
              $member->leader_id != $old_leader_id ||
              $member->network_id != $old_network_id) {

                $old_leader_code = $member->leader_code;
                $member->leader_code = $this->generateLeaderCode($member);
                $member->save();

                $member_unders = Member::where('leader_code','like',$old_leader_code."-%")->get();
                foreach ($member_unders as $under) {
                  if ($member->network_id != $old_network_id) {
                    $under->network_id = $member->network_id;
                  }

                  if ($member->level > $old_level) {
                    $under->level++;
                  }else if ($member->level < $old_level) {
                    $under->level--;
                  }

                  $under->leader_code = $this->generateLeaderCode($under);
                  $under->save();
                }
          }


          if($request->hasFile('picture')) {
              if ($member->dp_filename != "default.png") {
                unlink(public_path().'/dp/'.$member->dp_filename);
              }
             $file = $request->file('picture');
             $filename = str_random(60).'.'.$file->getClientOriginalExtension();
             $file->move(public_path().'/dp/', $filename);
             $member->dp_filename = $filename;
             $member->save();
          }

          $training->update([
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
              'errors'=>$validator->errors()->all()
              ]);
      }
  }

  public function updateStatus($id,$inactive){
    $member = Member ::findOrFail($id);
    $member->inactive=$inactive;
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
