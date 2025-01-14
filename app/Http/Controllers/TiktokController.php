<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TikTok\Authentication\Authentication;

class TiktokController extends Controller
{
    public function login()
    {
        $authentication = new Authentication(array( // instantiate authentication
            'client_key' => env('TIKTOK_CLIENT_ID'), // client key from your app
            'client_secret' => env('TIKTOK_CLIENT_SECRET'), // client secret from your app
        ));

// uri TikTok will send the user to after they login that must match what you have in your app dashboard
        // $redirectUri = 'https://path/to/tiktok/login/redirect.php';
        $redirectUri = env('TIKTOK_REDIRECT_URI');

        $scopes = array( // a list of approved scopes by tiktok for your app
            'user.info.basic',
            'user.info.profile',
            'user.info.stats',
            'video.publish',
            'video.upload',
            'video.list',
        );

        $authenticationUrl = $authentication->getAuthenticationUrl($redirectUri, $scopes);
        return view('tiktoklogin', ['authenticationUrl' => $authenticationUrl]);

        // return redirect($authenticationUrl);
    }

    public function handleCallback(Request $request)
    {
        // Get the code from the URL query parameter
        $code = $request->query('code');

        // Instantiate the Authentication class again for token exchange
        $authentication = new Authentication([
            'client_key' => env('TIKTOK_CLIENT_ID'),
            'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        ]);

        // Define the redirect URI
        $redirectUri = env('TIKTOK_REDIRECT_URI');

        // Exchange the code for an access token
        $tokenFromCode = $authentication->getAccessTokenFromCode($code, $redirectUri);

        // Get the user token from the response
        $userToken = $tokenFromCode['access_token'];

        // Now that you have the access token, you can use it to fetch user data
        // Here you can store the token and user data in the session or database
        // For now, let's return the token as a response
        return response()->json(['access_token' => $userToken]);
    }

    public function refreshAccessToken($accessToken)
    {
        $authentication = new Authentication([
            'client_key' => env('TIKTOK_CLIENT_ID'),
            'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        ]);

        // Refresh the token
        $tokenRefresh = $authentication->getRefreshAccessToken($accessToken);

        // Get the new access token
        $newUserToken = $tokenRefresh['access_token'];

        return response()->json(['new_access_token' => $newUserToken]);
    }

    public function revokeAccessToken($accessToken)
    {
        $authentication = new Authentication([
            'client_key' => env('TIKTOK_CLIENT_ID'),
            'client_secret' => env('TIKTOK_CLIENT_SECRET'),
        ]);

        // Revoke the token
        $revokeToken = $authentication->revokeAccessToken($accessToken);

        return response()->json(['status' => 'Token revoked']);
    }
}