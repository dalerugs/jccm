<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Validator;
use Auth;
use App\Member;

class FileController extends Controller
{

  public function showFilesPage(){
    $this->middleware('auth');
    $data['page_title'] = "Files";
    $data['page_description'] = "Browse Files";
    $data['active'] = "filesNav";
    $data['profile_picture'] = "default.png";
    if (Auth::user()->type=="NET_LEAD") {
      $member = Member::find(Auth::user()->network);
      $data['profile_picture'] = $member->dp_filename;
    }
    return view("page.files",$data);
  }

  public function create(Request $request){
    $validator = Validator::make($request->all(), [
        'file' => 'required',
        'name' => 'required',
        'description' => 'required',
    ]);
    if ($validator->passes()) {
          $file = $request->file('file');
          $filename = str_random(60).'.'.$file->getClientOriginalExtension();
          $file->move(public_path().'/files_upload/', $filename);

          $file = File::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'filename' => $filename,
          ]);
          return response()->json([
            'success' => true,
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
    return File::orderBy('name')->get();
  }

  public function show($id)
  {
      return File::find($id);
  }

  public function update(Request $request)
  {
      $file = File::findOrFail($request->input('id'));
      $validator = Validator::make($request->all(), [
          'name' => 'required',
          'description' => 'required',
      ]);
      if ($validator->passes()) {
          $file->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
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

  public function delete($id)
  {
      $file = File::findOrFail($id);
      unlink(public_path().'/files_upload/'.$file->filename);
      $file->delete();
      return 204;
  }
}
