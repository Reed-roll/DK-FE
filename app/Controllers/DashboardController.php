<?php

namespace App\Controllers;

class DashboardController extends BaseController
{
    protected $baseURL;

    public function __construct()
    {
        $this->baseURL = getenv('API_URL');
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $role = session()->get('role');
        if ($role === 'creator') {
            return redirect()->to('creator/dashboard');
        } else {
            return redirect()->to('client/dashboard');
        }
    }

    // Creator dashboard
    public function creatorDashboard()
    {
        // Check if user is logged in and is a creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return redirect()->to('login');
        }

        $client = \Config\Services::curlrequest();
        $userName = session()->get('name');
        
        try {
            // Match the feed's implementation for portfolio fetching
            log_message('debug', 'Making request to: ' . $this->baseURL . '/portfolio/findAll');
            
            $response = $client->post($this->baseURL . '/portfolio/findAll');
            
            log_message('debug', 'Response status: ' . $response->getStatusCode());
            log_message('debug', 'Response body: ' . $response->getBody());

            return view('dashboard/creator', [
                'title' => 'Creator Dashboard',
                'creator' => [
                    'id' => session()->get('user_id'),
                    'name' => $userName
                ],
                'debug' => [
                    'url' => $this->baseURL . '/portfolio/findAll',
                    'response' => $response->getBody(),
                    'status' => $response->getStatusCode()
                ],
                'baseURL' => $this->baseURL
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Dashboard error: ' . $e->getMessage());
            
            return view('dashboard/creator', [
                'title' => 'Creator Dashboard',
                'error' => 'Failed to load dashboard. Please try again later.',
                'debug' => [
                    'url' => $this->baseURL . '/portfolio/findAll',
                    'error' => $e->getMessage()
                ],
                'baseURL' => $this->baseURL
            ]);
        }
    }

    public function deletePortfolio($id)
    {
        // Check if user is logged in and is a creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return redirect()->to('login');
        }

        $client = \Config\Services::curlrequest();
        $apiSessionId = session()->get('api_session_id');

        try {
            // Make DELETE request with authentication
            $response = $client->request('DELETE', $this->baseURL . '/portfolio/delete', [
                'headers' => [
                    'Cookie' => 'ci_session=' . $apiSessionId
                ],
                'query' => [
                    'id' => $id
                ]
            ]);

            if ($response->getStatusCode() === 200) {
                return redirect()->to('/creator/dashboard')
                    ->with('success', 'Portfolio berhasil dihapus');
            }

            return redirect()->to('/creator/dashboard')
                ->with('error', 'Gagal menghapus portfolio');

        } catch (\Exception $e) {
            log_message('error', 'Delete portfolio error: ' . $e->getMessage());
            return redirect()->to('/creator/dashboard')
                ->with('error', 'Gagal menghapus portfolio: ' . $e->getMessage());
        }
    }

    public function updatePortfolio($id)
    {
        // Check if user is logged in and is a creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return redirect()->to('login');
        }

        $client = \Config\Services::curlrequest();
        $apiSessionId = session()->get('api_session_id');

        try {
            // Prepare form data
            $formData = [
                'id' => $id
            ];

            // Add optional fields if they exist
            if ($this->request->getPost('title')) {
                $formData['title'] = $this->request->getPost('title');
            }
            if ($this->request->getPost('description')) {
                $formData['description'] = $this->request->getPost('description');
            }
            if ($this->request->getPost('category')) {
                $formData['category'] = $this->request->getPost('category');
            }

            // Make request to update portfolio
            $response = $client->post($this->baseURL . '/portfolio/update', [
                'headers' => [
                    'Cookie' => 'ci_session=' . $apiSessionId
                ],
                'form_params' => $formData
            ]);

            if ($response->getStatusCode() === 200) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Portfolio berhasil diperbarui'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui portfolio'
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Update portfolio error: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal memperbarui portfolio: ' . $e->getMessage()
            ]);
        }
    }

    // Client dashboard
    public function clientDashboard()
    {
        // Check if user is logged in and is a client
        if (!session()->get('logged_in') || session()->get('role') !== 'client') {
            return redirect()->to('login');
        }

        $userId = session()->get('user_id');

        // Get client's projects
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->baseURL . '/project/findByUser',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'user_id' => $userId
            ])
        ]);
        
        $response = curl_exec($curl);
        $projects = json_decode($response, true);
        curl_close($curl);

        $data = [
            'title' => 'Client Dashboard',
            'projects' => $projects['data'] ?? [],
        ];

        return view('dashboard/client', $data);
    }
}