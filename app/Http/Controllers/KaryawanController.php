<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $user = user::all();
        return view('karyawan.index',compact('user'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ])->validate();

        User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'level'=> $request->level
        ]);

        return redirect()->route('user.index')->with('success', 'Timeline added successfully');
    }

    public function show()
    {
        //
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('karyawan.edit',compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'level' => 'required',
        ]);
        $user = User::findOrFail($id);
        $user->update($request->all());
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function destroy(string $id)
    {
        $User = User::find($id);
        $User->delete();
        return back()->with('success', 'User Deleted successfully');
    }
}
