<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupProdukModel;
use App\Models\ProdukModel;

class DesignerDashboard extends BaseController
{
    // protected $filters = ['auth'];

    private $userData = [];
    private $statistics = '';
    private $pager = '';

    public function __construct() {
        $session = session();
        $user_id = $session->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->where('user_id', $user_id)
                          ->first();

        $this->userData = [
            'username' => $user['username'],
            'name' => $user['name'],
            'name_designer' => $user['name_designer'],
            'email' => $user['email'],
            'address' => $user['address'],
            'user_id' => $user['user_id'],
            'follower_count' => $user['follower_count'],
            'following_count' => $user['following_count'],
        ];

        $statistics = '';
        $pager = '';
    }

    public function add_produk(){
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


    public function index()
    {
        return view('designer/designer_dashboard', [
            'userData' => $this->userData,
            'statistics' => $this->statistics,
            'pager'=>$this->pager
        ]);
    }

}