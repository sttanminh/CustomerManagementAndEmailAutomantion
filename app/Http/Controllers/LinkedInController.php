<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LinkedInReadController extends Controller
{
    /**
     * Get LinkedIn access token from session.
     *
     * @return string|null
     */
    private function getAccessToken()
    {
        return session('linkedin_access_token');
    }

    /**
     * Retrieve Ad Accounts.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAdAccounts()
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $response = Http::withToken($accessToken)->get('https://api.linkedin.com/rest/adAccounts', [
            'headers' => ['Accept' => 'application/json']
        ]);

        return $response->json();
    }

    /**
     * Retrieve Campaign Groups.
     *
     * @param string $adAccountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampaignGroups($adAccountId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $response = Http::withToken($accessToken)
            ->get("https://api.linkedin.com/rest/adAccounts/{$adAccountId}/adCampaignGroups", [
                'headers' => ['Accept' => 'application/json']
            ]);

        return $response->json();
    }

    /**
     * Retrieve Campaigns for an Ad Account.
     *
     * @param string $adAccountId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampaigns($adAccountId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $response = Http::withToken($accessToken)
            ->get("https://api.linkedin.com/rest/adAccounts/{$adAccountId}/adCampaigns", [
                'headers' => ['Accept' => 'application/json']
            ]);

        return $response->json();
    }

    /**
     * Retrieve Ad Creatives for a campaign.
     *
     * @param string $campaignId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCreatives($campaignId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $response = Http::withToken($accessToken)
            ->get("https://api.linkedin.com/rest/adCampaigns/{$campaignId}/creatives", [
                'headers' => ['Accept' => 'application/json']
            ]);

        return $response->json();
    }

    /**
     * Retrieve available targeting facets.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTargetingFacets()
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $response = Http::withToken($accessToken)
            ->get("https://api.linkedin.com/rest/adTargetingFacets", [
                'headers' => ['Accept' => 'application/json']
            ]);

        return $response->json();
    }

    /**
     * Retrieve specific targeting entities (e.g., industries, job titles).
     *
     * @param string $facetUrn
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTargetingEntities($facetUrn)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $response = Http::withToken($accessToken)
            ->get("https://api.linkedin.com/rest/adTargetingEntities?q=adTargetingFacet&facet={$facetUrn}", [
                'headers' => ['Accept' => 'application/json']
            ]);

        return $response->json();
    }

    /**
     * Retrieve Campaign Analytics.
     *
     * @param Request $request
     * @param string $campaignId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCampaignAnalytics(Request $request, $campaignId)
    {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) return response()->json(['error' => 'Unauthorized'], 401);

        $startDate = $request->query('start_date', '2024-01-01');
        $endDate = $request->query('end_date', '2024-12-31');

        $response = Http::withToken($accessToken)
            ->get("https://api.linkedin.com/rest/adAnalytics?q=analytics&campaign.values[0]=$campaignId&dateRange.start.year=2024&dateRange.end.year=2024", [
                'headers' => ['Accept' => 'application/json']
            ]);

        return response()->json($response->json());
    }
}
