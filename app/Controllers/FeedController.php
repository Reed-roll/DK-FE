<?php

namespace App\Controllers;

class FeedController extends BaseController
{
    protected $baseURL;

    public function __construct()
    {
        $this->baseURL = getenv('API_URL');
    }

    private function getCreatorName($creatorId)
    {
        $client = \Config\Services::curlrequest();
        try {
            log_message('debug', 'Fetching name for creator ID: ' . $creatorId);
            
            $response = $client->get($this->baseURL . '/users/findNameById?id=' . $creatorId);
            
            log_message('debug', 'findNameById response: ' . $response->getBody());
            
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                if (isset($data['name'])) {
                    return $data['name'];
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Error fetching creator name: ' . $e->getMessage() . ' for ID: ' . $creatorId);
        }
        return 'Unknown Creator';
    }

    public function index()
    {
        $client = \Config\Services::curlrequest();
        
        try {
            log_message('debug', 'Making request to: ' . $this->baseURL . '/portfolio/findAll');
            
            $response = $client->post($this->baseURL . '/portfolio/findAll');
            
            log_message('debug', 'Response status: ' . $response->getStatusCode());
            log_message('debug', 'Response body: ' . $response->getBody());

            $portfolios = json_decode($response->getBody(), true);

            // Fetch creator names for each portfolio
            if (!empty($portfolios)) {
                foreach ($portfolios as &$portfolio) {
                    $portfolio['creator_name'] = $this->getCreatorName($portfolio['creator_id']);
                }
            }

            $data = [
                'title' => 'Portfolio Feed',
                'baseURL' => $this->baseURL,
                'debug' => [
                    'url' => $this->baseURL . '/portfolio/findAll',
                    'response' => json_encode($portfolios),
                    'status' => $response->getStatusCode()
                ]
            ];

            return view('feed/index', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Feed error: ' . $e->getMessage());
            return view('feed/index', [
                'title' => 'Portfolio Feed',
                'portfolios' => [],
                'error' => $e->getMessage(),
                'debug' => [
                    'url' => $this->baseURL . '/portfolio/findAll',
                    'error' => $e->getMessage()
                ]
            ]);
        }
    }

    public function creatorProfile($id)
    {
        $client = \Config\Services::curlrequest();
        
        try {
            // Get creator details
            $url = $this->baseURL . '/users/findById?id=' . $id;
            log_message('debug', '=== CREATOR PROFILE DEBUG ===');
            log_message('debug', 'Request URL: ' . $url);
            
            $creatorResponse = $client->get($url);
            
            log_message('debug', 'Response Status Code: ' . $creatorResponse->getStatusCode());
            log_message('debug', 'Response Body: ' . $creatorResponse->getBody());
            
            if ($creatorResponse->getStatusCode() !== 200) {
                throw new \Exception('Creator not found. Status code: ' . $creatorResponse->getStatusCode());
            }

            $creator = json_decode($creatorResponse->getBody(), true);
            log_message('debug', 'Decoded Creator Data: ' . json_encode($creator));

            // Get creator's portfolios using URL encoded name
            log_message('debug', '=== PORTFOLIO DEBUG ===');
            
            $encodedName = urlencode($creator['name']);
            $portfolioUrl = $this->baseURL . '/portfolio/findByCreator?name=' . $encodedName;
            log_message('debug', 'Portfolio Request URL: ' . $portfolioUrl);
            
            $portfolioResponse = $client->get($portfolioUrl);
            log_message('debug', 'Portfolio Response Status: ' . $portfolioResponse->getStatusCode());
            log_message('debug', 'Portfolio Response Body: ' . $portfolioResponse->getBody());

            $portfolios = [];
            if ($portfolioResponse->getStatusCode() === 200) {
                $portfolioData = json_decode($portfolioResponse->getBody(), true);
                $portfolios = $portfolioData['data'] ?? [];
                log_message('debug', 'Decoded Portfolio Data: ' . json_encode($portfolios));
            }

            return view('feed/creatorProfile', [
                'title' => ($creator['name'] ?? 'Unknown') . ' - Profile',
                'creator' => $creator,
                'portfolios' => $portfolios,
                'baseURL' => $this->baseURL
            ]);

        } catch (\Exception $e) {
            log_message('error', '=== ERROR DEBUG ===');
            log_message('error', 'Error Message: ' . $e->getMessage());
            log_message('error', 'Error Trace: ' . $e->getTraceAsString());
            
            return view('feed/creatorProfile', [
                'title' => 'Creator Profile',
                'error' => 'Kreator tidak ditemukan: ' . $e->getMessage(),
                'baseURL' => $this->baseURL
            ]);
        }
    }
}
