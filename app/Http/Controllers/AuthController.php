<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\User;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')
                    ->scopes(['repo'])
                    ->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user = Socialite::driver('github')->user();

        if ($found = User::find($user->getId())) {
            Auth::login($found);
        } else {
            Auth::login(User::create([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'username' => $user->getNickname(),
                'token' => $user->token,
            ]));
        }

        return redirect()->action('ReposController@index');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/')->with('status', 'You have been logged out');
    }
}
