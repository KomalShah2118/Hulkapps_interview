<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Excel;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('role_as','=','0')->get();
        return view('admin.dashboard',compact('users'));
    }

    public function verifyStudent($id){
        $users = User::find($id);
        $users->is_verified = 1;
        $users->update();
        // $users = User::where('id','=',$id)->update(['is_verified'=>1]);
        Mail::send('emails.studentVerification', ['name' => ucfirst($users->name)], function ($message) use ($users) {
            $message->to($users->email);
            $message->subject('Student Verification');
        });
        return redirect('/dashboard')->with('status','Student Verified.');
    }

    public function editStudent($id){
        $users = User::find($id);
        return view('admin.studentEdit',compact('users'));
    }

    public function updateStudent(Request $request,$id){
        $users = User::find($id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->date_of_birth = $request->dob;
        $users->address = $request->address;
        $users->save();

        return redirect('/dashboard')->with('status', 'Student Updated Successfully.');
    }

    public function export(){
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function importView(){
        $failures = array();
        return view('admin.import',compact('failures'));
    }

    public function importData(){
        try{
            Excel::import(new UsersImport,request()->file('file'));
            return redirect('/dashboard');
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e)
        {
            $failures = $e->failures();
            return view ('admin.import', compact('failures'));
        }
    }

}
