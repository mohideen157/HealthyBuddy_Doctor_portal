<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Auth;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
// use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    // use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    // use AuthenticatesUsers, RegistersUsers {
    //     AuthenticatesUsers::redirectPath insteadof RegistersUsers;
    //     AuthenticatesUsers::guard insteadof RegistersUsers;
    // }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function redirectToProvider($provider)
    {
        dd("Archito Testing.." . $provider);
    }

    public function handleProviderCallback($provider)
    {
        dd("Archito Testing here now " . $provider);
    }


     /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function redirectPath()
    {
        $route = "";

        $user = Auth::user();
       //dd( $user);
        switch($user->user_role)
        {
            case '1':
                $route = "admin";
                break;

            case '9':
                $route = $user->tenant_details->slug.'/organisation';
                break;

            case '10':
                $route = '/organisation/patient-profile';
                break;

            case '2':
                $route = 'doctor/patient-profile';
                break;

            case '11':
                $route = 'caregiver/dashboard';
                break;

            default: break;
        }
        
        return $route;
    }
}
