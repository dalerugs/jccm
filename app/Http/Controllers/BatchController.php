<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Batch;
use Validator;

class BatchController extends Controller
{
  public function create(Request $request){
      $validator = Validator::make($request->all(), [
          'no' => 'required|integer|min:1|unique:batches',
          'name' => 'required',
          'description' => 'required',
      ],
      [
        'no.unique' => 'The batch no already exist.',
      ]);
      if ($validator->passes()) {
            $user = Batch::create($request->all());
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
    return Batch::all();
  }

  public function show($id)
  {
      return Batch::find($id);
  }

  public function update(Request $request)
  {
      $batch = Batch::findOrFail($request->input('id'));
      $validator = Validator::make($request->all(), [
          'no' => 'required|integer|min:1',
          'name' => 'required',
          'description' => 'required',
      ]);
      if ($validator->passes()) {
          $batch->update($request->all());
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
      $batch = Batch::findOrFail($id);
      $batch->delete();
      return 204;
  }
}
