<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
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
        $this->middleware('guest')->except('logout');
    }

    //google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    //google callback
    public function handleGoogleCallBack()
    {
        $user = Socialite::driver('google')->stateless()->user();

        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    //facebook login
//    public function redirectToFacebook()
//    {
//        return Socialite::driver('facebook')->redirect();
//    }
//
//    //facebook callback
//    public function handleFacebookCallBack()
//    {
//        $user = Socialite::driver('facebook')->user();
//    }

    //github login
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    //github callback
    public function handleGithubCallBack()
    {
        $user = Socialite::driver('github')->user();
        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect()->route('home');
    }

    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        if(!$user) {
           $user = new User();
           $user->name = $data->name;
           $user->email = $data->email;
           $user->provider_id = $data->id;
           $user->avatar = $data->avatar;
           $user->save();
        }
        Auth::login($user);
    }
}
