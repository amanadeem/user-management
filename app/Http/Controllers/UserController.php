<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Validator;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $users = User::all();
        if($request->ajax()){
            return DataTables::of($users)->make(true);
        }
        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|min:8',
            'password' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);
        return redirect('/users');
    }
    // Method to return user data for editing
    public function get(User $user) 
    {
        // dd($user);
        // $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }



    public function update(Request $request)
    {
        // Validate standard fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => ['required',Rule::unique('users')->ignore($request->user_id)],
            'phone' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return back()->with('error', $validator->errors()->first());
        }

        $user = User::find($request->user_id);
        if ($user) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            return back()->with('success', 'User updated successfully.');
        } else {
            return back()->with('error', 'User not found.');
        }
    }

    public function delete(User $user)
    {
        // $user = User::find($id);
        if ($user) {
            $user->delete();
            return back()->with('success', 'User deleted successfully.');
        } else {
            return back()->with('error', 'User not found.');
        }
    }

}
