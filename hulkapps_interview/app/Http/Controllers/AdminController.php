<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

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

}
