<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected function authenticated()
    {
        if(Auth::user()->role_as == '1') //1 = Admin Login
        {
            return redirect('/dashboard')->with('status','Welcome to admin dashboard');
        }
        elseif(Auth::user()->role_as == '0') // Normal or Default User Login
        {
            if(Auth::user()->is_verified == '1'){
                return redirect('/home')->with('status','Logged in successfully');
            }
            else{
                // $this->middleware('guest')->except('logout');
                return redirect('/login')->with('status', 'Admin will verify your details soon');
            }
            // return redirect('/home')->with('status','Logged in successfully');
        }
        else{
            return redirect('/login');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
