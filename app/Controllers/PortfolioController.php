<?php

namespace App\Controllers;

class PortfolioController extends BaseController
{
    protected $baseURL;

    public function __construct()
    {
        $this->baseURL = getenv('API_URL');
    }

    public function create()
    {
        // Check session role for creator
        if (!session()->get('logged_in') || session()->get('role') !== 'creator') {
            return redirect()->to('/dashboard')->with('error', 'Only creators can add portfolios');
        }

        // If GET request, show the form
        if ($this->request->getMethod() !== 'POST') {
            return view('portfolio/create', [
                'title' => 'Create Portfolio'
            ]);
        }

        // Handle POST request
        try {
            // Get API session ID
            $apiSessionId = session()->get('api_session_id');
            if (!$apiSessionId) {
                throw new \RuntimeException('API session not found. Please login again.');
            }

            // Validate file
            $file = $this->request->getFile('portfolio_file');
            if (!$file->isValid()) {
                throw new \RuntimeException($file->getErrorString());
            }

            // Debug logs
            log_message('debug', '=== PORTFOLIO CREATE DEBUG ===');
            log_message('debug', 'API Session ID: ' . $apiSessionId);
            log_message('debug', 'User ID: ' . session()->get('user_id'));
            log_message('debug', 'User Role: ' . session()->get('role'));

            // Initialize cURL
            $curl = curl_init();

            // Prepare file for upload
            $postFields = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'category' => $this->request->getPost('category'),
                'portfolio_file' => new \CURLFile(
                    $file->getTempName(),
                    $file->getClientMimeType(),
                    $file->getName()
                )
            ];

            // Set cURL options
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->baseURL . '/portfolio/create',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postFields,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: multipart/form-data'
                ],
                CURLOPT_COOKIE => 'ci_session=' . $apiSessionId
            ]);

            // Execute cURL request
            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            log_message('debug', 'Response Status: ' . $httpCode);
            log_message('debug', 'Response Body: ' . $response);
            
            // Check for cURL errors
            if (curl_errno($curl)) {
                throw new \RuntimeException('Curl error: ' . curl_error($curl));
            }

            // Close cURL connection
            curl_close($curl);

            // Parse response
            $result = json_decode($response, true);

            if ($httpCode === 201) {
                return redirect()->to('/dashboard')->with('success', 'Portfolio created successfully!');
            } else {
                $errorMessage = isset($result['messages']['error']) ? $result['messages']['error'] : 'Failed to create portfolio';
                throw new \RuntimeException($errorMessage);
            }

        } catch (\Exception $e) {
            log_message('error', 'Portfolio create error: ' . $e->getMessage());
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create portfolio: ' . $e->getMessage());
        }
    }
}