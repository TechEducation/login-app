<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\User;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
      return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
      try {

        $user = Socialite::driver($provider)->user();

        $createUser = User::firstOrCreate([
          'email' => $user->getEmail()
        ], [
          'name' => $user->getName()
        ]);

        auth()->login($createUser);
        return redirect('/home')->with('alert', "Bienvenido $createUser->name");

      }catch(\GuzzleHttp\Exception\ClientException $e) {
        dd($e);
      }
    }
}
