<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

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

    protected $maxLoginAttempts = 10; // Amount of bad attempts user can make
    //protected $lockoutTime = 300; // Time for which user is going to be blocked in seconds

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       /* $this->middleware('guest')->except('logout');*/
    }


    public function do_login(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');
        $remember_me = $request->has('remember') ? true : false; 

        if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password],$remember_me) || Auth::guard('web')->attempt(['username' => $email, 'password' => $password],$remember_me))
        {
            $user_id = Auth::user()->id;
            if(User::find($user_id)->hasRole('Admin'))
            {
            return Redirect::to('admin');
            }else {
            return Redirect::to('user/profile')->with( 'notice', "Welcome to cryptoexchange. You can now start Trading." ); 
            }
        }else{
          die('not!!!');
        }
    }
}
