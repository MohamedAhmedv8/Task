<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function store(Request $request)
    {
        $access_token= $request->header('access_token');
        $validator= Validator::make($request->all(),[
            "title"=>"required|string",
            "description"=>"required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message"=>$validator->errors()
            ],301);
        }
        $user= User::where('access_token',$access_token)->first();
        Note::create([
            "title"=>$request->title,
            "description"=>$request->description,
            "user_id"=>$user->id
        ]);
            return response()->json([
                "message"=>"Your Note has been added"
            ],200);
    }
    public function show(Request $request)
    {
        $access_token= $request->header('access_token');
        
        $user= User::where('access_token',$access_token)->first();
        $notes= Note::where('user_id',$user->id)->get();
        if ($notes->isEmpty()) {
            return response()->json([
                "message"=>"No Notes"
            ],301);
        }else{
            return NoteResource::collection($notes);
        }
    }
    public function update(Request $request,$id)
    {
        $access_token= $request->header('access_token');
        $validator= Validator::make($request->all(),[
            "title"=>"string",
            "description"=>"string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message"=>$validator->errors()
            ],301);
        }
        $user= User::where('access_token',$access_token)->first();
        $note= Note::where('user_id',$user->id)->first();
        if ($note) {
            if ($note->user_id == $user->id) {
                if ($request->has('title')) {
                    $note['title'] = $request->title;
                    }
                if ($request->has('description')) {
                    $note['description'] = $request->description;
                }
                    $note->save();
                    return response()->json([
                        "message"=>"Your Note Is Updated Successfully"
                    ],200);
            }else{
                return response()->json([
                    "message"=>"There Is No Note For You"
                ],404);
            }
        }else{
            return response()->json([
                "message"=>"No Note exists"
            ],404);
        }
    }
    public function delete(Request $request,$id)
    {
        $access_token= $request->header('access_token');
        $user= User::where('access_token',$access_token)->first();
        $note= Note::where('id',$id)->first();
        if ($note) {
            if ($note->user_id == $user->id) {
                $note->delete();
                    return response()->json([
                        "message"=>"Your Note Is Deleted Successfully"
                    ],200);
            }else{
                return response()->json([
                    "message"=>"There Is No Note For You"
                ],301);
            }
        }else{
            return response()->json([
                "message"=>"No Note exists"
            ],404);
        }
    }
}
