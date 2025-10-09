<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $inputs = $request->only('email', 'password');
        if (auth()->guard('web')->attempt($inputs)) {
            return redirect()->intended('dashboard');
        }
        return redirect()->back()->withErrors([
            'email' => 'Invalid credentials, please try again.',
        ])->withInput($request->except('password'));
    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function getData()
    {
        $issues = Issue::all();
        return response()->json([
            'data' => $issues
        ]);
    }
    public function add()
    {
        $users = User::all();
        return view('addissue', compact('users'));
    }
    public function create(Request $request)
    {
        $inputs = $request->all();

        $validated = $request->validate(
            [
                'bug' => 'required',
                'comment' => 'required',
                'file' => 'required',
                'status' => 'required'
            ],
            [
                'bug.required' => 'please add bugs/issues',
                'comment.required' => 'please add a comment',
                'status.required' => 'please include status'
            ]
        );
        // dd($validated);
        $issue = Issue::create($inputs);
        return redirect()->route('dashboard')->with('message', 'issue added successfully');
    }
    public function edit($id)
    {
        $issue = Issue::find($id);
        return view('editissue', compact('issue'));
    }
    public function update(Request $request)
    {
        $inputs = $request->all();

        $validated = $request->validate(
            [
                'bug' => 'required',
                'comment' => 'required',
                'file' => 'required',
                'status' => 'required'
            ],
            [
                'bug.required' => 'please add bugs/issues',
                'comment.required' => 'please add a comment',
                'status.required' => 'please include status'
            ]
        );
        // dd($validated);
        $issue = Issue::create($inputs);
        return redirect()->route('dashboard')->with('message', 'issue added successfully');
    }
}
