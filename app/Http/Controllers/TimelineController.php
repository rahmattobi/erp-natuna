<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\timeline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $timelines = Timeline::with('user')->get();
        // $user = User::all();

        // return view('timelines.index',compact('timelines','user'));
        $timelines = timeline::all();
        $jsonData = timeline::select('title', 'start', 'end','category')->get();
        return view('timelines.index',compact ('timelines','jsonData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $timelines = Timeline::with('user')->get();
        // $user = User::all();
        // return view('timelines.input',compact('timelines','user'));
        $timelines = timeline::all();
        return view('timelines.input',compact ('timelines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'title' => 'required',
            'start' => 'required',
            'end' => 'required',
            'category' => 'required'
        ])->validate();

        Timeline::create($request->all());

        return redirect()->route('timeline')->with('success', 'Timeline added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(timeline $timeline)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // $timelines = timeline::with('user')->findOrFail($id);
        // $user = User::all();
        $timelines = timeline::findOrFail($id);
        return view('timelines.edit',compact('timelines'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required',
        ]);
        $timeline = timeline::findOrFail($id);
        $timeline->update($request->all());
        return redirect()->route('timeline')->with('success', 'Timeline updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $timelines = timeline::find($id);
        $timelines->delete();
        return back()->with('success', 'Timeline Deleted successfully');
    }
}
