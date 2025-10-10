<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Issue;
use App\Models\StatusLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

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
        // dd(Gate::allows('isAdmin', auth()->user()));
        return view('dashboard');
    }
    public function getData()
    {
        $user = Auth::user();
        if($user->name === 'admin'){
            $issues = Issue::with('assignedUser')->get();
        }
        else{
            $issues = Issue::with('assignedUser')->where('assigned_to',$user->id)->get();
        }
        // return DataTables::of($issues)
        // ->addColumn('assigned_user',function($issue){
        //     return $issue->assignedUser->name;
        // })->with([
        //     'data'=>$issues,
        // ])
        // ->make(true);
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
        // dd($inputs);
        $validated = $request->validate(
            [
                'bug' => 'required',
                'comment' => 'required',
                'status' => 'required',
                'hours'=>'required',
                'start_date'=>'required',
            ],
            [
                'bug.required' => 'please add bugs/issues',
                'comment.required' => 'please add a comment',
                'status.required' => 'please include status',
                'hours.required'=>'please include hours',
                'start_date.required'=>'startin date required'
            ]
        );
        // dd($validated);
        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->extension();
            $filename = "Image".time().".".$extension;
            $path = $request->file('file')->storeAs('uploads',$filename,'public');
            $inputs['file'] = $filename;
        }
    //    dd($inputs);
        Issue::create($inputs);
        $issue = Issue::latest()->first();
        StatusLog::create([
            'issue_id'=>$issue->id,
            'user_id'=>auth()->user()->id,
            'old_status'=>$request->status

        ]);
        return redirect()->route('dashboard')->with('message', 'issue added successfully');
    }
    public function view($id){
        $issue = Issue::find($id);
        return view('view',compact('issue'));
    }
    public function edit($id)
    {
        $issue = Issue::find($id);
        $users = User::all();
        return view('editissue', compact('issue','users'));
    }
    public function update(Request $request,$id)
    {
        $issue = Issue::find($id);
        // $inputs = $request->only(['bug','comment','file','status','assigned_to']);
        $inputs = $request->all();
        // dd($inputs);
        $validated = $request->validate(
            [
                'bug' => 'required',
                'comment' => 'required',
                'status' => 'required',
                'hours'=>'required',
                'start_date'=>'required',
            ],
            [
                'bug.required' => 'please add bugs/issues',
                'comment.required' => 'please add a comment',
                'status.required' => 'please include status',
                'hours.required'=>'please include hours',
                'start_date.required'=>'startin date required'
            ]
        );
        // dd($validated);
        if($request->hasFile('file')){
            // if ($issue->file && Storage::disk('public')->exists($issue->file)) {
            //     Storage::disk('public/uploads')->delete($issue->file);
            // }
            // dd("ggfd");
            $file = $request->file('file');
            $extension = $file->extension();
            $filename = "Image".time().".".$extension;
            $path = $request->file('file')->storeAs('uploads',$filename,'public');
            $inputs['file'] = $filename;
        }
        $issue->update($inputs);
        // dd($issue->status,$request->status);
        $statuslog = StatusLog::where('issue_id',$id)->first();
       
        if($statuslog->old_status != $request->status && $statuslog->user_id === auth()->user()->id){
            StatusLog::where('issue_id',$id)->update(attributes: [
                'issue_id'=>$issue->id,
                'user_id'=> auth()->user()->id,
                'new_status'=> $request->status,
            ]);
        }
        // if($statuslog->user_id != auth()->user()->id){
        //     StatusLog::create(attributes: [
        //         'issue_id'=>$issue->id,
        //         'user_id'=> auth()->user()->id,
        //         'old_status'=> $request->status,
        //     ]);
        // }
        return redirect()->route('dashboard')->with('message', 'issue updated successfully');
    }
    public function delete($id){
        $issue = Issue::find(id: $id);
        $issue->delete();
        return redirect()->route('dashboard')->with('delete','issue deleted successfully');
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
