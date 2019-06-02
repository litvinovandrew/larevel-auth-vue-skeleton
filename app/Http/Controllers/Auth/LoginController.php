<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SocialAccountsService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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


    protected function authenticated(Request $request, $user)
    {
        if ( $user->isAdmin() ) {// do your margic here
            return redirect()->route('admin');
        }

        return redirect('/');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();

    }

    /**
     * Obtain the user information from provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver)
    {

        try {
            $providerUser = Socialite::driver($driver)->user();
        } catch (\Exception $e) {
            echo PHP_EOL . PHP_EOL . '<br><br>File: ' . __FILE__ . '<br>' . PHP_EOL;
            echo 'Line: ' . (__LINE__ + 1) . '<br>' . PHP_EOL; die(var_dump($e));
            echo '<br><br>' . PHP_EOL . PHP_EOL;
            return redirect()->route('/');
        }

        if ($providerUser) {
            $existingUser =  (new SocialAccountsService())->findOrCreate($providerUser, $driver);
            auth()->login($existingUser, true);
        }

        return redirect()->route('home');



    }
}
