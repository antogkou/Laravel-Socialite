<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginGitHubController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::firstOrCreate(
            [
                'provider_id' => $githubUser->getId(),
            ],
            [
                'email' => $githubUser->getEmail(),
                'name' => $githubUser->getName(),
            ]
        );

        // $user = User::where('provider_id', $githubUser->getId())->first();
        // // Create user in db
        // if (!$user) {
        //     $user = User::create([
        //         'email' => $githubUser->getEmail(),
        //         'name' => $githubUser->getName(),
        //         'provider_id' => $githubUser->getId()
        //     ]);
        // }

        //Login user
        Auth::login($user, true);

        //Redirect to dashboard
        return redirect('dashboard');
    }
}
