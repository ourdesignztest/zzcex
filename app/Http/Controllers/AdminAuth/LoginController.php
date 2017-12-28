<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

//Auth facade
use Auth;

class LoginController extends Controller
{
     //Trait
    use AuthenticatesUsers;

    //Where to redirect seller after login.
    protected $redirectTo = '/admin_home';

    //Trait
    use AuthenticatesUsers;

    //Custom guard for seller
    protected function guard()
    {
      return Auth::guard('admin');
    }

    //Shows seller login form
   public function showLoginForm()
   {
       return view('admin.login');
   }


    public function logout(Request $request)
    {
      
        Auth::guard('admin')->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return Redirect::to('/admin_home');

    }
}

