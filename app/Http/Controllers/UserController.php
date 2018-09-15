<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|string|min:6|unique:users',
            'type' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);
        if ($validator->passes()) {
              $user = User::create([
                  'first_name' => $request->input('first_name'),
                  'last_name' => $request->input('last_name'),
                  'username' => $request->input('username'),
                  'type' => $request->input('type'),
                  'network' => empty($request->input('network'))?0:$request->input('network'),
                  'password' => Hash::make($request->input('password')),
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
      return User::all();
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|string|min:6|unique:users,username,'.$user->id,
            'type' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ]);
        if ($validator->passes()) {
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'type' => $request->input('type'),
                'network' => empty($request->input('network'))?0:$request->input('network'),
                'password' => Hash::make($request->input('password')),
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
        $user = User::findOrFail($id);
        $user->delete();
        return 204;
    }
}
