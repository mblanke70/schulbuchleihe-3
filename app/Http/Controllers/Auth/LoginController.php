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

        //dd($iservUser->token . ' - '. $iservUser->refreshToken . " - " . $iservUser->expiresIn);

        //dd($iservUser);

        /*
         *  Gets the user in our database where the provider ID
         *  returned matches a user we have stored.
         */
        $user = User::where( 'email', '=', $iservUser->email )->first();
        
        //dd($user);

        /*
         *  Checks to see if a user exists. If not we need to create the
         *  user in the database before logging them in.
         */
        if( $user == null ) {
            $newUser = new User();

            $newUser->name     = $iservUser->getName();
            $newUser->vorname  = $iservUser["given_name"];
            $newUser->nachname = $iservUser["family_name"];
            $newUser->email    = $iservUser->getEmail();

            foreach($iservUser["groups"] as $key => $val) {
                if( substr($val["name"], 0, 6) == "Klasse" ) {
                    $newUser->klasse   = substr($val["name"], 7);
                    $newUser->jahrgang = substr($val["name"], 7, 2);
                    break;
                }
            }

            $newUser->save();
            $user = $newUser;
        }

        /*
         *  Log in the user
         */
        Auth::login( $user );
 
        if ( $user->istAdmin() ) {
            return redirect()->intended('admin/');
        }

        return redirect()->intended('user/');
    }

    public function logout()
    {
        Auth::logout();
    }
}
