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

        if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password]))
         {
         //dd(Auth::user());
           $user_id = Auth::user()->id;
           if(User::find($user_id)->hasRole('Admin'))
           {
                return Redirect::to('admin');
           } 
      
         
           else {
             return Redirect::to('user/profile')->with( 'notice', "Welcome to cryptoexchange. You can now start Trading." ); 

           }

           
         }else{
            die('pennding not!!!');
         }
         print_r($password);
         die;
        die('here');
    }
}
