<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|numeric|digits:11',
            'username' => 'required|string|min:6|unique:users',
            'type' => 'required',
        ],
        [
          'numeric' => 'The mobile number is invalid.',
          'digits' => 'The mobile number is invalid.',
        ]);
        if ($validator->passes()) {
              $user = User::create([
                  'first_name' => $request->input('first_name'),
                  'last_name' => $request->input('last_name'),
                  'mobile_number' => $request->input('mobile_number'),
                  'username' => $request->input('username'),
                  'type' => $request->input('type'),
                  'network' => empty($request->input('network'))?0:$request->input('network'),
                  'password' => Hash::make($request->input('password')),
                  'change_password' => 1,
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
      return User::orderBy('first_name')->get();
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function generateTemporaryPassword()
    {
        return Str::random(6);
    }

    public function resetPassword($id)
    {
        $temporaryPassword = Str::random(6);
        $user = User::findOrFail($id);
        $user->update([
          'password' => Hash::make($temporaryPassword),
          'change_password' => 1,
        ]);
        return $temporaryPassword;
    }

    public function changePasswordApi(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6|confirmed'
        ]);

        if ($validator->passes()) {
            $user->update([
              'password' => Hash::make($request->input('password')),
              'change_password' => 0,
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

    public function update(Request $request)
    {
        $user = User::findOrFail($request->input('id'));
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile_number' => 'required|regex:/^([0-9]*)$/|min:11|max:11',
            'username' => 'required|string|min:6|unique:users,username,'.$user->id,
            'type' => 'required',
        ],
        [
          'regex' => 'The mobile number is invalid.',
          'max' => 'The mobile number is invalid.',
          'min' => 'The mobile number is invalid.'
        ]);

        if ($validator->passes()) {
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'username' => $request->input('username'),
                'type' => $request->input('type'),
                'mobile_number' => $request->input('mobile_number'),
                'network' => empty($request->input('network'))?0:$request->input('network'),
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
