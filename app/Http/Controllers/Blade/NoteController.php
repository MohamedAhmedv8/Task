<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id',Auth::user()->id)->get();
        return view('notes.note_view',compact('notes'));
    }
    public function create()
    {
        return view('notes.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            "title"=>"required|string",
            "description"=>"required|string"
        ]);
        Note::create([
            "title"=>$request->title,
            "description"=>$request->description,
            "user_id"=>Auth::user()->id,
        ]);
        return redirect()->route('note_view')->with('success', 'Your Note has been added');
    }
    public function edit($id)
    {
        $note= Note::FindOrFail($id);
        if ($note->user_id == Auth::user()->id) {
            return view('notes.update',compact('note'));
        }else{
            return back();
        }
    }
    public function update(Request $request)
    {
        $request->validate([
            "title"=>"required|string",
            "description"=>"required|string"
        ]);
        $note= Note::FindOrFail($request->id);
        if ($note->user_id == Auth::user()->id) {
            $note->update([
                "title"=>$request->title,
                "description"=>$request->description,
            ]);
        }
        return redirect()->route('note_view')->with('success', 'Your Note has been Updated');

    }
    public function delete($id)
    {
        $note= Note::FindOrFail($id);
        if ($note->user_id == Auth::user()->id) {
            $note->delete();
            return redirect()->route('note_view')->with('success', 'Your Note has been Deleted');
        }else{
            return back();
        }
    }
}
