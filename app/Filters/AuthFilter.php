<?php

namespace App\Filters;

use Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Memeriksa apakah pengguna telah login
        if (!session('id_user')) {
            $session = session();
            
            $session->set('previous_url',current_url());
            
            $request = Services::request();
            $data_post = $request->getPost();
            if (!empty($data_post)){
                $session->set('data_post', $data_post);
            }

            
            return redirect()->to('/login'); // Redirect ke halaman login jika belum login
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Implementasi setelah filter (jika diperlukan)
    }
}
