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
    
            // Add project fetch with logging and authentication
            log_message('debug', '[Project] Making request to: ' . $this->baseURL . '/project/findByUser');
            log_message('debug', '[Project] Session ID: ' . session()->get('api_session_id'));
            
            $projectResponse = null;
            try {
                $projectResponse = $client->post($this->baseURL . '/project/findByUser', [
                    'headers' => [
                        'Cookie' => 'ci_session=' . session()->get('api_session_id')
                    ]
                ]);
                log_message('debug', '[Project] Response status: ' . $projectResponse->getStatusCode());
                log_message('debug', '[Project] Response body: ' . $projectResponse->getBody());
            } catch (\Exception $e) {
                log_message('error', '[Project] Fetch error: ' . $e->getMessage());
            }
    
            return view('dashboard/creator', [
                'title' => 'Creator Dashboard',
                'creator' => [
                    'id' => session()->get('user_id'),
                    'name' => $userName
                ],
                'debug' => [
                    'url' => $this->baseURL . '/portfolio/findAll',
                    'response' => $response->getBody(),
                    'status' => $response->getStatusCode(),
                    'project_debug' => isset($projectResponse) ? [
                        'response' => $projectResponse->getBody(),
                        'status' => $projectResponse->getStatusCode()
                    ] : null
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

    public function updateProject($id)
    {
        // Check if user is logged in and is a creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        $client = \Config\Services::curlrequest();
        
        try {
            log_message('debug', '[Project Update] Making request to: ' . $this->baseURL . '/project/update');
            
            // Get the request data
            $status = $this->request->getPost('status');
            
            // Make request to update project
            $response = $client->post($this->baseURL . '/project/update', [
                'headers' => [
                    'Cookie' => 'ci_session=' . session()->get('api_session_id')
                ],
                'form_params' => [
                    'id' => $id,
                    'status' => $status
                ]
            ]);

            log_message('debug', '[Project Update] Response status: ' . $response->getStatusCode());
            log_message('debug', '[Project Update] Response body: ' . $response->getBody());

            if ($response->getStatusCode() === 200) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Project berhasil diupdate'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal mengupdate project'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Project Update] Error: ' . $e->getMessage());
            log_message('error', '[Project Update] Trace: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteProject($id)
    {
        // Check if user is logged in and is a creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        $client = \Config\Services::curlrequest();
        
        try {
            log_message('debug', '[Project Delete] Making request to: ' . $this->baseURL . '/project/delete');
            
            // Make request to delete project
            $response = $client->post($this->baseURL . '/project/delete', [
                'headers' => [
                    'Cookie' => 'ci_session=' . session()->get('api_session_id')
                ],
                'form_params' => [
                    'id' => $id
                ]
            ]);

            log_message('debug', '[Project Delete] Response status: ' . $response->getStatusCode());
            log_message('debug', '[Project Delete] Response body: ' . $response->getBody());

            if ($response->getStatusCode() === 200) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Project berhasil dihapus'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal menghapus project'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Project Delete] Error: ' . $e->getMessage());
            log_message('error', '[Project Delete] Trace: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    public function createProject()
    {
        // Check if user is logged in and is a creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Unauthorized access'
            ]);
        }

        $client = \Config\Services::curlrequest();
        
        try {
            log_message('debug', '[Project Create] Making request to: ' . $this->baseURL . '/project/create');
            
            // Get the request data
            $projectData = [
                'client_id' => $this->request->getPost('client_id'),
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'category' => $this->request->getPost('category'),
                'status' => 'pending', // Default status
                'deadline' => $this->request->getPost('deadline')
            ];
            
            // Make request to create project
            $response = $client->post($this->baseURL . '/project/create', [
                'headers' => [
                    'Cookie' => 'ci_session=' . session()->get('api_session_id')
                ],
                'form_params' => $projectData
            ]);

            log_message('debug', '[Project Create] Response status: ' . $response->getStatusCode());
            log_message('debug', '[Project Create] Response body: ' . $response->getBody());

            if ($response->getStatusCode() === 201) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Project berhasil dibuat'
                ]);
            }

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal membuat project'
            ]);

        } catch (\Exception $e) {
            log_message('error', '[Project Create] Error: ' . $e->getMessage());
            log_message('error', '[Project Create] Trace: ' . $e->getTraceAsString());
            
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function getClientName($id)
    {
        $client = \Config\Services::curlrequest();
        try {
            $response = $client->get($this->baseURL . '/users/findNameById?id=' . $id);
            $data = json_decode($response->getBody(), true);
            return $data['name'] ?? 'Client #' . $id;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching client name: ' . $e->getMessage());
            return 'Client #' . $id;
        }
    }

    // Client dashboard
    public function clientDashboard()
    {
        // Check if user is logged in and is a client
        if (!session()->get('logged_in') || session()->get('role') !== 'client') {
            return redirect()->to('login');
        }
    
        $client = \Config\Services::curlrequest();
        $apiSessionId = session()->get('api_session_id');
    
        try {
            // Make request to get user's projects
            $response = $client->post($this->baseURL . '/project/findByUser', [
                'headers' => [
                    'Cookie' => 'ci_session=' . $apiSessionId
                ]
            ]);
            
            $projects = json_decode($response->getBody(), true);
            
            return view('dashboard/client', [
                'title' => 'Client Dashboard',
                'projects' => $projects['data'] ?? [],
                'baseURL' => $this->baseURL
            ]);
    
        } catch (\Exception $e) {
            log_message('error', 'Failed to fetch projects: ' . $e->getMessage());
            
            return view('dashboard/client', [
                'title' => 'Client Dashboard',
                'projects' => [],
                'error' => 'Failed to load projects. Please try again later.',
                'baseURL' => $this->baseURL
            ]);
        }
    }
}