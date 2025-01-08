<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class AuthController extends BaseController
{
    protected $baseURL;

    public function __construct() 
    {
        $this->baseURL = getenv('API_URL');
    }

    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $curl = curl_init();
            
            // Create a temp file in CI's writable directory
            $cookieJar = WRITEPATH . 'temp/cookies_' . uniqid() . '.txt';
            
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->baseURL . '/users/login',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query([
                    'email' => $email,
                    'password' => $password
                ]),
                CURLOPT_HEADER => true,  // Include headers in response
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/x-www-form-urlencoded'
                ]
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            // Split headers and body
            $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $headerSize);
            $body = substr($response, $headerSize);
            
            curl_close($curl);

            // Clean up temp file if it was created
            if (file_exists($cookieJar)) {
                unlink($cookieJar);
            }

            // Debug log
            log_message('debug', '=== LOGIN DEBUG ===');
            log_message('debug', 'Response Headers: ' . $headers);
            log_message('debug', 'Response Body: ' . $body);
            log_message('debug', 'HTTP Code: ' . $httpCode);

            $result = json_decode($body, true);

            if ($httpCode === 200) {
                // Parse Set-Cookie header from API response
                preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $headers, $matches);
                $cookies = array();
                foreach($matches[1] as $item) {
                    parse_str($item, $cookie);
                    $cookies = array_merge($cookies, $cookie);
                }

                // Debug cookies
                log_message('debug', 'Received Cookies: ' . json_encode($cookies));

                // Extract session ID from Cookie header
                $sessionId = null;
                if (preg_match('/ci_session=([^;]+)/', $headers, $matches)) {
                    $sessionId = $matches[1];
                }

                // Set session data
                session()->set([
                    'user_id' => $result['user']['id'],
                    'email' => $result['user']['email'],
                    'role' => $result['user']['role'],
                    'logged_in' => true,
                    'api_session_id' => $sessionId
                ]);

                // Debug final session
                log_message('debug', 'Final Session Data: ' . json_encode(session()->get()));

                if ($result['user']['role'] === 'creator') {
                    return redirect()->to(base_url('creator/dashboard'));
                } else {
                    return redirect()->to(base_url('client/dashboard'));
                }
            }

            return redirect()->back()->with('error', 'Email atau password salah');
        }

        return view('auth/login');
    }

    public function logout()
    {
        // Get API session cookie
        $apiSessionId = session()->get('api_session_id');
        
        if ($apiSessionId) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->baseURL . '/users/logout',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_COOKIE => 'ci_session=' . $apiSessionId
            ]);
            curl_exec($curl);
            curl_close($curl);
        }

        session()->destroy();
        return redirect()->to(base_url());
    }

    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url());
        }

        if ($this->request->getMethod() === 'POST') {
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
                'role' => $this->request->getPost('role')
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->baseURL . '/users/register',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($userData)
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);

            if ($httpCode === 201) {
                return redirect()->to(base_url('login'))->with('success', 'Registrasi berhasil, silakan login');
            }

            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat mendaftar');
        }

        return view('auth/register');
    }
}