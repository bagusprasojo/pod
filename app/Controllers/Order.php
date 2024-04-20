<?php

namespace App\Controllers;
use App\Models\UserModel;
use App\Models\CartModel;


class Order extends BaseController
{
	private $userData = [];
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

    private function simpan_cart($id_desain, $id_produk, $id_produk_size){


    	$cartModel = new CartModel();
    	$existingCart = $cartModel->where('id_desain', $id_desain)
                              ->where('id_produk', $id_produk)
                              ->where('id_produk_size', $id_produk_size)
                              ->first();

		if ($existingCart) {
			$cartModel->update($existingCart['id_cart'], ['qty' => $existingCart['qty'] + 1]);
	    } else {
	    	$cartData = [	    		
	            'id_user' => $this->user['id_user'],
	            'id_desain' => $id_desain,
	            'id_produk' => $id_produk,
	            'id_produk_size' => $id_produk_size,
	            'qty' => 1,
	        ];

	        $cartModel->insert($cartData);
	    }
    }
    public function add_cart() {
    	if (strtoupper($this->request->getMethod()) === 'GET') {
    		$session = session();
    		$data_post = $session->get('data_post');

    		

    		if (!empty($data_post)) {
    			$id_desain = esc($data_post['id_desain']);
			    $id_produk = esc($data_post['id_produk']);
			    $id_produk_size = esc($data_post['id_produk_size']);

			    
			    $this->simpan_cart($id_desain, $id_produk, $id_produk_size);
    		}    	
    	} else {
	    	$id_desain = esc($this->request->getPost('id_desain'));
		    $id_produk = esc($this->request->getPost('id_produk'));
		    $id_produk_size = esc($this->request->getPost('id_produk_size'));

		    $this->simpan_cart($id_desain, $id_produk, $id_produk_size);
		}

    	
    }

}