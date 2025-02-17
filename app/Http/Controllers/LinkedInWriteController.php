<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LinkedInWriteController extends Controller
{
    private function getAccessToken()
    {
        return session('linkedin_access_token');
    }

    /**
     * Create an Ad Account.
     */
    public function createAdAccount(Request $request)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $payload = [
            'currency' => 'USD',
            'name' => $request->input('name'),
            'reference' => "urn:li:organization:{$request->input('organization_id')}",
            'type' => 'BUSINESS'
        ];

        $response = Http::withToken($accessToken)->post("https://api.linkedin.com/rest/adAccounts", $payload);

        return $response->json();
    }

    /**
     * Create a Campaign Group.
     */
    public function createCampaignGroup(Request $request, $adAccountId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $payload = [
            'account' => "urn:li:sponsoredAccount:{$adAccountId}",
            'name' => $request->input('name'),
            'status' => 'ACTIVE',
            'totalBudget' => [
                'amount' => $request->input('budget'),
                'currencyCode' => 'USD'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->post("https://api.linkedin.com/rest/adAccounts/{$adAccountId}/adCampaignGroups", $payload);

        return $response->json();
    }

    /**
     * Create a Campaign.
     */
    public function createCampaign(Request $request, $adAccountId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $payload = [
            'account' => "urn:li:sponsoredAccount:{$adAccountId}",
            'name' => $request->input('name'),
            'type' => 'TEXT_AD',
            'dailyBudget' => [
                'amount' => $request->input('budget'),
                'currencyCode' => 'USD'
            ]
        ];

        $response = Http::withToken($accessToken)
            ->post("https://api.linkedin.com/rest/adAccounts/{$adAccountId}/adCampaigns", $payload);

        return $response->json();
    }
}
