<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserProfileController extends Controller
{
    public function show(Request $request) 
    {
        $access_token = $request->header('access_token');
        $user_data = User::where('access_token',$access_token)->first();
        if ($user_data) {
            return response()->json([
                "user_name"=>$user_data->user_name,
                "email"=>$user_data->email,
            ],200);
        }else{
            return response()->json([
            "message"=>"User Not Found"
            ],404);
        }
    }
    public function update(Request $request) 
    {
        $access_token = $request->header('access_token');
        $user = User::where('access_token', $access_token)->first();
        if (!$user) {
            return response()->json([
                "message" => "User Not Found"
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'user_name' => 'string|unique:users,user_name' ,
            'email' => 'email|unique:users,email',
            'password' => 'min:5'
        ]);
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 301);
        }
        if ($request->has('user_name')) {
            $user->user_name = $request->user_name;
        }
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json([
            "message" => "Profile Updated Successfully",
            "user" => [
                "user_name" => $user->user_name,
                "email" => $user->email
            ]
        ], 200);
    }
}
