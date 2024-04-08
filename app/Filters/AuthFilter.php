<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Memeriksa apakah pengguna telah login
        if (!session('user_id')) {
            return redirect()->to('/login'); // Redirect ke halaman login jika belum login
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Implementasi setelah filter (jika diperlukan)
    }
}
