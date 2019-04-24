<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;

use Auth;   
use Socialite;

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
    //protected $redirectTo = '/home';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
/*
    protected function redirectTo()
    {
        return '/user/home';
    }
*/
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('iserv')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $iservUser = Socialite::driver('iserv')->stateless()->user();

        dd($iservUser);
        
        $user = User::where( 'email', $iservUser->email )->first();
        
        /*
         *  Checks to see if a user exists. If not we need to create the
         *  user in the database before logging them in.
         */
        
        if( $user == null )
        {
            $user = new User();
            $user->email = $iservUser["email"];
        }

        $user->name     = $iservUser->getName();
        $user->vorname  = $iservUser["given_name"];
        $user->nachname = $iservUser["family_name"];
         
        foreach($iservUser["groups"] as $key => $val) 
        {
            if( substr($val["name"], 0, 6) == "Klasse" ) 
            {
                $user->klasse   = substr($val["name"], 7);
                $user->jahrgang = substr($val["name"], 7, 2);
                break;
            }
        }

        $user->save();

        Auth::login( $user );

        if ( $user->istAdmin() ) 
        {
            return redirect()->intended('nova/');
        }

        return redirect()->intended('user/');
    }

    public function logout()
    {
        Auth::logout();
    }
}