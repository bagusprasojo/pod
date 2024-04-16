<?php
// File: app/Controllers/Assets.php

namespace App\Controllers;

use CodeIgniter\Controller;

class Assets extends Controller
{
    public function desain($file)
    {
        $filepath = ROOTPATH . 'assets/desain/' . $file;
        
        if (file_exists($filepath) && is_file($filepath)) {
            $gambar = file_get_contents($filepath);

            return $this->response
                ->setStatusCode(200)
                ->setContentType(mime_content_type($filepath))
                ->setBody($gambar);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }

    public function produk($file)
    {
        $filepath = ROOTPATH . 'assets/produk/' . $file;
        
        if (file_exists($filepath) && is_file($filepath)) {
            $gambar = file_get_contents($filepath);

            return $this->response
                ->setStatusCode(200)
                ->setContentType(mime_content_type($filepath))
                ->setBody($gambar);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}
