<?php

namespace App\Listeners;

use App\Models\User;
use Dcblogdev\MsGraph\MsGraph;
use Illuminate\Support\Facades\Auth;

class NewMicrosoft365SignInListener
{
    public function handle($event)
    {
        // Get user email from Microsoft response
        $email = $event->token['info']['mail'] ?? $event->token['info']['userPrincipalName'];

        // Check if user exists in database
        $user = User::where('email', $email)->first();

        // If user doesn't exist, you might want to:
        // 1. Create them (as in original)
        // 2. Deny access
        // 3. Redirect to registration

        if (!$user) {
            // // Option 1: Create user
            // $user = User::create([
            //     'name' => $event->token['info']['displayName'],
            //     'email' => $email,
            //     'password' => '', // No password needed for OAuth
            // ]);

            // Option 2: Deny access
            return redirect()->route('login')->with('error', 'User not registered');
        }

        // Store token
        (new MsGraph())->storeToken(
            $event->token['accessToken'],
            $event->token['refreshToken'],
            $event->token['expires'],
            $user->id,
            $user->email
        );

        Auth::login($user);
    }
}
