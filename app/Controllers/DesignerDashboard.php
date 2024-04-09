<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupProdukModel;
use App\Models\ProdukModel;
use App\Models\DesainModel;

class DesignerDashboard extends BaseController
{
    // protected $filters = ['auth'];

    private $userData = [];
    private $statistics = '';
    private $pager = '';
    private $user;

    public function __construct() {
        $session = session();
        $id_user = $session->get('id_user');

        $userModel = new UserModel();
        $this->user = $userModel->where('id_user', $id_user)
                          ->first();

        $this->userData = [
            'username' => $this->user['username'],
            'name' => $this->user['name'],
            'name_designer' => $this->user['name_designer'],
            'email' => $this->user['email'],
            'address' => $this->user['address'],
            'id_user' => $this->user['id_user'],
            'follower_count' => $this->user['follower_count'],
            'following_count' => $this->user['following_count'],
        ];

        $statistics = '';
        $pager = '';
    }

    private function add_produk_get(){
        
        $groupProdukModel = new GroupProdukModel();
        $groupProduks = $groupProdukModel->findAll();

        $produkModel = new ProdukModel();
        $produks = $produkModel->findAll();



        return view('designer/add_produk', [
            'userData' => $this->userData,
            'groupProduks' => $groupProduks,
            'produks' => $produks,
        ]);
    }
    
    public function show(){
        echo "<img src='" . site_url('assets/desain/dawud.jpg') .  "' alt='Photo'>";
    }

    public function add_produk(){
        if (strtoupper($this->request->getMethod()) === 'GET') {
            return $this->add_produk_get();
        } else {
            $gambar = $this->request->getFile('gambarInput');
            $path = ROOTPATH . 'assets/desain';
            $newName = '';

            if ($gambar->isValid() && !$gambar->hasMoved())
            {
                $newName = $gambar->getRandomName();                
                $gambar->move($path, $newName);

                // Lakukan operasi lainnya, misalnya menyimpan nama file di database

                // Redirect atau tampilkan pesan sukses
                // return redirect()->to('/upload/success');
            } else{
                // File tidak valid, tampilkan pesan error
                $error = $gambar->getError();
                return "Upload failed: $error";
            }

            $desainModel = new DesainModel();
            $desainData = [
                'nama' => esc($this->request->getPost('nama_desain')),
                'tag' => esc($this->request->getPost('tag')),
                'deskripsi' => esc($this->request->getPost('deskripsi')),
                'url_desain' => $path . $newName,
                'desain_aktif' => 1, 
                'id_user' => $this->user['id_user'],
                
            ];

            // var_dump($desainData);
            // die();
            $desainModel->insert($desainData);

            echo base_url('asset/desain/' . $newName);
        }

    }


    public function index()
    {
        return view('designer/designer_dashboard', [
            'userData' => $this->userData,
            'statistics' => $this->statistics,
            'pager'=>$this->pager
        ]);
    }

}