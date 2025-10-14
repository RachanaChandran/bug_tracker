<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
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
        // dd($issue->assigned_to);
        StatusLog::create([
            'issue_id'=>$issue->id,
            'user_id'=>auth()->user()->id,
            'assigned_to'=>$issue->assigned_to,
            'old_status'=>$request->status,
            'new_status'=>$request->status,
        ]);
        $data = [
            'issue_id'=>$issue->id,
            'user_id'=>auth()->user()->id,
            'comment'=>$request->comment,
        ];
        if($request->hasfile('image')){
            $data['image'] = $filename;
        }
        
        Comment::create($data);
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
        $statuslog = StatusLog::where('issue_id',$issue->id)->latest()->first();
            if($statuslog === null){
                StatusLog::create([
                'issue_id'=>$issue->id,
                'user_id'=> auth()->user()->id,
                'assigned_to'=>$request->assigned_to,
                'old_status'=>$request->status,
                'new_status'=> $request->status,
            ]);
            }
            elseif($statuslog->new_status != $request->status){
                StatusLog::create([
                'issue_id'=>$issue->id,
                'user_id'=> auth()->user()->id,
                'assigned_to'=>$request->assigned_to,
                'old_status'=>$statuslog->new_status,
                'new_status'=> $request->status,
            ]);
            }
            $data = [
            'issue_id'=>$issue->id,
            'user_id'=>auth()->user()->id,
            'comment'=>$request->comment,
            ];
            if($request->hasfile('image')){
                $data['image'] = $filename;
            }
            
            Comment::create($data);
        
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
        $statuslogs = StatusLog::where('issue_id',$id)->delete();
        return redirect()->route('dashboard')->with('delete','issue deleted successfully');
    }
    public function statusLog(){
        return view('statuslogs');
    }
    public function statusGetData(){
        $statuslogs = StatusLog::with('issue','user','assignedTo')->get()->map(function($statuslogs){
            return [
                'issue'=> optional($statuslogs->issue)->bug,
                'user'=> optional($statuslogs->user)->name,
                'assignedto'=>optional($statuslogs->assignedTo)->name,
                'old_status'=> $statuslogs->old_status,
                'new_status'=>$statuslogs->new_status
            ];
        });
        // dd($statuslogs);
        return response()->json([
            'data'=>$statuslogs
        ]);
    }
    public function comment($id){
        $comments = Comment::where('issue_id',$id)->with('issue','user')->get();
        return view('comments',compact('comments'));
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
