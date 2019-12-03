<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $user_info = Socialite::driver($provider)->user();
        $user = $this->createUser($user_info, $provider);
        auth()->login($user);

        return redirect()->route('library');
    }

    private function createUser($user_info, $provider)
    {
        $user = User::firstOrCreate([
            'provider_id' => $user_info->id,
        ], [
            'name'     => $user_info->name,
            'email'    => $user_info->email,
            'provider' => $provider,
        ]);

        return $user;
    }
}
