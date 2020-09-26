<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginnController extends Controller
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

   // use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOMEADMIN;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }
    
    public function showLoginnForm()
    {
        return view('admin.login');
    }

    
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    // protected function guard()
    // {
    //     return Auth::guard('admin');    
    // } 

    public function login(Request $request)
    {
       //validate request  data

       ($this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]));
        
       //attempt to login

       if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password')],$request->remember))
       { 
       //If successful
        return redirect()->intended(route('admin.home'));
       }; 
       //If unsuccessful
        $mess='Account not found !!';
       return redirect()->back()->withInput($request->only('email','remember'))
                                ->with('error',$mess);
     }
}
