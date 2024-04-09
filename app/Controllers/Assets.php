<?php
// File: app/Controllers/Assets.php

namespace App\Controllers;

use CodeIgniter\Controller;

class Assets extends Controller
{
    public function index($file)
    {
        $filepath = FCPATH . '../assets/desain/' . $file;
        echo $filepath;
        // die();

        if (file_exists($filepath) && is_file($filepath)) {
            $file = file_get_contents($filepath);

            return $this->response
                ->setStatusCode(200)
                ->setContentType(mime_content_type($filepath))
                ->setBody($file);
        }

        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}
