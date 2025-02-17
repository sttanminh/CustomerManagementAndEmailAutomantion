<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\LinkedInToken;

class LinkedInAuthController extends Controller
{
    /**
     * Redirects the user to LinkedIn OAuth authorization page.
     *
     * This function generates an authorization URL for LinkedIn, requesting
     * the required scopes for accessing LinkedIn Ads API.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToLinkedIn()
    {
        $clientId = env('LINKEDIN_CLIENT_ID');
        $redirectUri = urlencode(env('LINKEDIN_REDIRECT_URI'));
        $scopes = 'r_ads,r_ads_reporting,rw_ads'; // Required scopes for campaign access

        // Construct LinkedIn OAuth URL
        $authUrl = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=$clientId&redirect_uri=$redirectUri&scope=$scopes";

        return redirect($authUrl);
    }

    /**
     * Handles the LinkedIn OAuth callback and stores the access token.
     *
     * This function exchanges the authorization code for an access token
     * and stores it in the session and database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleLinkedInCallback(Request $request)
    {
        // Retrieve authorization code from LinkedIn callback
        $code = $request->query('code');

        // Request access token from LinkedIn
        $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'redirect_uri'  => env('LINKEDIN_REDIRECT_URI'),
            'client_id'     => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        ]);

        // Decode JSON response
        $data = $response->json();

        if (!isset($data['access_token'])) {
            return redirect('/error')->with('error', 'Failed to authenticate with LinkedIn.');
        }

        $accessToken = $data['access_token'];
        $expiresIn = $data['expires_in']; // Token expiration time in seconds

        // Store access token in session for quick access
        session(['linkedin_access_token' => $accessToken]);

        // Store token in database for long-term use
        LinkedInToken::updateOrCreate(
            ['id' => 1], // Ensure only one token record exists
            [
                'access_token' => $accessToken,
                'expires_at' => now()->addSeconds($expiresIn), // Store expiration date
            ]
        );

        return redirect('/campaigns'); // Redirect to campaigns page
    }
}
