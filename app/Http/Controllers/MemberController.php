<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;
use App\Training;
use Validator;

class MemberController extends Controller
{
  public function create(Request $request){
      $validator = Validator::make($request->all(), [
          'first_name' => 'required',
          'last_name' => 'required',
          'sex' => 'required',
          'birth_date' => 'required',
          'address' => 'required',
          'level' => 'required',
          'batch' => 'required',
      ]);
      if ($validator->passes()) {
        $filename = "default.png";
        if($request->hasFile('picture')) {
           $file = $request->file('picture');
           $filename = str_random(60).'.'.$file->getClientOriginalExtension();
           $file->move(public_path().'/dp/', $filename);
        }
        $member = Member::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'birth_date' => $request->input('birth_date'),
            'sex' => $request->input('sex'),
            'address' => $request->input('address'),
            'level' => $request->input('level'),
            'network_id' => empty($request->input('network_id'))?0:$request->input('network_id'),
            'leader_id' => empty($request->input('leader_id'))?0:$request->input('leader_id'),
            'dp_filename' => $filename,
        ]);
        Training::create([
            'member'=> $member->id,
            'batch'=> $request->input('batch'),
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
    $members = Member::all();
    foreach ($members as $member) {
      $member['network_leader'] = "N/A";
      $member['leader'] = "N/A";
      if ($member->network_id > 0) {
        $network_leader = Member::find($member->network_id);
        $member['network_leader'] = $network_leader->first_name." ".$network_leader->last_name;
      }
      if ($member->leader_id > 0) {
        $leader = Member::find($member->leader_id);
        $member['leader'] = $leader->first_name." ".$leader->last_name;
      }
    }
    return $members;
  }

  public function show($id)
  {
      return Member::find($id);
  }

  public function update(Request $request)
  {
      $member = Member::findOrFail($request->input('id'));
      $validator = Validator::make($request->all(), [
          'no' => 'required|integer|min:1',
          'name' => 'required',
          'description' => 'required',
      ]);
      if ($validator->passes()) {
          $member->update($request->all());
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

  public function delete($id)
  {
      $member = Member ::findOrFail($id);
      $member->delete();
      return 204;
  }
}
