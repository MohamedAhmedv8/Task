<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        $validator= Validator::make($request->all(),[
        "user_name"=>"required|string|unique:users,user_name",
        "email"=>"required|email|unique:users,email",
        "password"=>"required|min:5",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message"=>$validator->errors()
            ],301);
        }
        $password = Hash::make($request->password);
        User::create([
            "user_name"=>$request->user_name,
            "email"=>$request->email,
            "password"=>$password,
            "access_token"=>null,
        ]);
        return response()->json([
            "message"=>"Your Register Successfully"
        ],200);
    }
    public function login(Request $request)
    {
        $validator= Validator::make($request->all(),[
        "user_name"=>"required|string",
        "password"=>"required|min:5",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message"=>$validator->errors()
            ],301);
        }
        $user_data = User::where("user_name",$request->user_name)->first();
        $access_token = Str::random(64);
        if ($user_data) {
            $password= Hash::check($request->password,$user_data->password);
            if ($password) {
                $user_data->update([
                    "access_token"=>$access_token
                ]);
                return response()->json([
                    "message"=>"Your Login Successfully",
                    "access_token"=>$access_token
                ],200);
            }else{
                return response()->json([
                    "message"=>"Your Data Not Correct"
                ],301);
            }
        }else{
            return response()->json([
                "message"=>"Your Data Not Correct"
            ],301);
        }
    }
    public function logout(Request $request)
    {
        $access_token= $request->header('access_token');

        if ($access_token != null) {
            $user_data = User::where('access_token',$access_token)->first();
            if ($user_data) {
                $user_data->update([
                    "access_token"=>null
                ]);
                return response()->json([
                "message"=>"Your Logout Successfully"
            ],200);
            }else{
            return response()->json([
                "message"=>"This Token Not Found"
            ],404);
            }
        }else{
            return response()->json([
                "message"=>"This Token Not Found"
            ],404);
        }
    }
}
