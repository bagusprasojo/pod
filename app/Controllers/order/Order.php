<?php

namespace App\Controllers\order;

use App\Controllers\BaseController;

use App\Models\EkspedisiModel;
use App\Models\UserModel;
use App\Models\AlamatUserModel;
use App\Models\CartModel;
use App\Models\ProdukModel;
use App\Models\ProdukSizeModel;
use App\Models\DesainModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;



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

    private function simpan_cart($id_desain, $id_produk, $id_produk_size, $url_image){
    	$cartModel = new CartModel();
    	$existingCart = $cartModel->where([
																    'id_desain' => $id_desain,
																    'id_produk' => $id_produk,
																    'id_produk_size' => $id_produk_size
																])->first();

			if ($existingCart) {
				$result = $cartModel->update($existingCart['id_cart'], ['qty' => $existingCart['qty'] + 1]);
	  	} else {
	    	$cartData = [	    		
	            'id_user' => $this->user['id_user'],
	            'id_desain' => $id_desain,
	            'id_produk' => $id_produk,
	            'id_produk_size' => $id_produk_size,
	            'qty' => 1,
	            'url_image' => $url_image,
	        ];

	        $result = $cartModel->insert($cartData);
	    }

	    return $result ? true : false;
    }

    public function add_cart() {
    	if (strtoupper($this->request->getMethod()) === 'GET') {
    		$session = session();
    		$data_post = $session->get('data_post');    		

    		if (!empty($data_post)) {
    			$id_desain = esc($data_post['id_desain']);
			    $id_produk = esc($data_post['id_produk']);
			    $id_produk_size = esc($data_post['id_produk_size']);

			    
			    $result = $this->simpan_cart($id_desain, $id_produk, $id_produk_size);
    		}    	
    	} else {
			$gambar = $this->request->getFile('image');
            $path = ROOTPATH . 'assets/cart/';
            $newName = '';

            $newName = $gambar->getRandomName();
            if ($gambar->isValid() && !$gambar->hasMoved())
            {
                $newName = $gambar->getRandomName();                
                $gambar->move($path, $newName);

                $id_desain = esc($this->request->getPost('id_desain'));
			    $id_produk = esc($this->request->getPost('id_produk'));
			    $id_produk_size = esc($this->request->getPost('id_produk_size'));

			    

			    $result = $this->simpan_cart($id_desain, $id_produk, $id_produk_size, $newName);
			    if ($result){
			    	$data = [
				        'status' => true,
				        'pesan' => 'Berhasil simpan ke keranjang',					        
				    ];
			    } else {
			    	$data = [
				        'status' => false,
				        'pesan' => 'Gagal simpan ke keranjang',					        
				    ];
			    }

            
            } else{
                // File tidak valid, tampilkan pesan error
                $error = $gambar->getError();
                $data = [
			        'status' => false,
			        'pesan' => $error,				        
			    ];
                
            }	    	

		    echo json_encode($data);
		}
			
    }

    public function get_data_summary_order(){
    	$cartModel = new CartModel();
    	$data_cart = $cartModel->select('SUM(b.harga * tb_cart.qty) as dpp')
    	                       ->join('m_produk_size b ', 'tb_cart.id_produk_size = b.id_produk_size')
    	                       ->Where('tb_cart.id_user',$this->user['id_user'])
    	                       ->first();

    	$dpp = intVal($data_cart['dpp']);
    	$ppn = intVal(11/100 * $dpp);
    	$total = intVal($dpp + $ppn);

    	$data = [
	        'status' => true,
	        'dpp' => $dpp,
	        'ppn' => $ppn,
	        'ongkir'=>0,
	        'total' => $total,
	    ];

	    return $data;
    	                       
    }

    public function show_cart(){
    	$cartModel = new CartModel();
    	$data_carts = $cartModel->select('b.nama as desain, b.url_desain, d.`name` as group_produk, c.color_name, c.url_image, e.size, e.harga, tb_cart.qty, tb_cart.uuid_cart, tb_cart.id_produk_size, tb_cart.id_cart')
    	                       ->join('m_desain b ', 'tb_cart.id_desain = b.id_desain')
    	                       ->join('m_produk c ', 'tb_cart.id_produk = c.id_produk')
    	                       ->join('m_group_produk d ', 'c.id_group_produk = d.id_group_produk')
    	                       ->join('m_produk_size e ', 'tb_cart.id_produk_size = e.id_produk_size')
    	                       // ->join('m_desain_gp f', 'c.id_group_produk = f.id_group_produk and c.color = f.color  and c.id_group_produk = f.id_group_produk') 
    	                       ->Where('tb_cart.id_user',$this->user['id_user'])
    	                       ->orderby('tb_cart.created_at')
    	                       ->findAll();

    	$data_summary = $this->get_data_summary_order();
    	$dpp = intVal($data_summary['dpp']);
    	$ppn = intVal($data_summary['ppn']);
    	$total = intVal($data_summary['total']);

    	return view('order/cart', [
            'userData' => $this->userData,
            'data_carts' => $data_carts,
            'dpp'=>$dpp,
            'ppn'=>$ppn,
            'total'=>$total,
        ]);
    }

    public function get_ongkir($uuid_order, $uuid_ekspedisi){
    	$orderModel = new OrderModel();
		$order = $orderModel->select('*')
		                    ->Where('uuid_order', $uuid_order)
		                    ->first();

		if ($order){
			$ekspedisiModel = new EkspedisiModel();
	    	$ekspedisi = $ekspedisiModel->select('tarif,id_ekspedisi')
	    								->Where(['uuid_ekspedisi' => $uuid_ekspedisi])->first();

	    	if ($ekspedisi) {
	    		$ongkir = intVal($ekspedisi['tarif']);	
	    		$total  = $order['dpp'] + $order['ppn']	+ $ongkir;		
	    		
	    		$orderModel->update($order['id_order'], ['ongkir' => $ongkir,
	    												 'total'=>$total, 
	    												 'id_ekspedisi'=>$ekspedisi['id_ekspedisi']]);

	    		$data = [
			        'status' => true,
			        'dpp' => intVal($order['dpp']),
			        'ppn' => intVal($order['ppn']),
			        'ongkir'=> intVal($ekspedisi['tarif']),
			        'total' => $order['dpp'] + $order['ppn'] + intVal($ekspedisi['tarif']),
			    ];	    		
	    	} else {
	    		$data = [
					'status' => false,
					'pesan' => 'Ongkir tidak ditemukan'
				];
	    	}	
		} else {
			$data = [
				'status' => false,
				'pesan' => 'Order tidak ditemukan'
			];
		}
    	

    	echo json_encode($data);
    }
    public function add_qty_cart($uuid_cart, $qty){
    	$cartModel = new CartModel();
    	$existingCart = $cartModel->where(['uuid_cart' => $uuid_cart])->first();

		if ($existingCart) {
			$produkSizeModel = new ProdukSizeModel();
	    	$produkSize = $produkSizeModel->where(['id_produk_size'=>$existingCart['id_produk_size']])->first();
	    	$stock = $produkSize['stock'];
	    	
	    	$data = ['status' => false];
	    	
			$qty_akhir = intVal($existingCart['qty']) + $qty;

			if ($qty_akhir > $stock){
				$data['status'] = false;
				$data['pesan'] = 'Stock tidak cukup';
			} else {
				if ((intVal($existingCart['qty']) + $qty) == 0){
					$result = $cartModel->where(['uuid_cart' => $uuid_cart])->delete();
				} else {
					$result = $cartModel->update($existingCart['id_cart'], ['qty' => $qty_akhir]);
				}

				if ($result) {
					$data = $this->get_data_summary_order();
					$data['status'] = true;
					$data['qty_akhir'] = $qty_akhir;

					if ((intVal($existingCart['qty']) + $qty) == 0){
						$data['jml_order'] = get_jml_order_cart();
					} 
				}		
			}
		
		}

		echo json_encode($data);

    }

    public function remove_item_cart($uuid_cart) {
    	
    	$cartModel = new CartModel();
    	$result = $cartModel->where('uuid_cart', $uuid_cart)->delete();

    	// echo $cartModel->db->getLastQuery();
    	// die();

    	if ($result){
			return redirect()->to('/order/show_cart');
		}
	}

	private function update_stock_produk_size($id_produk_size, $qty){
		$produkSizeModel = new ProdukSizeModel();

	    $produkSize = $produkSizeModel->find($id_produk_size);

	    if ($produkSize) {
	        $newQty = $produkSize['stock'] + $qty; 
	        $produkSizeModel->update($id_produk_size, ['stock' => $newQty]);

	        return true; // Mengembalikan nilai true jika berhasil memperbarui
	    } else {
	        return false; // Mengembalikan nilai false jika id_produk_size tidak ditemukan
	    }
	}

	public function callback(){
		echo "ASASSASA";
    }

	public function payment_success(){
		echo 'success';
	}

	public function pengiriman(){
		$alamat_user_model = new AlamatUserModel();
		$alamat = $alamat_user_model->select('label,provinsi,kabupaten, kecamatan, alamat, kode_pos, uuid_alamat_user')
		                             ->join('m_provinsi a','m_alamat_user.id_provinsi = a.id_provinsi')
		                             ->join('m_kabupaten b','m_alamat_user.id_kabupaten = b.id_kabupaten')
		                             ->join('m_kecamatan c','m_alamat_user.id_kecamatan = c.id_kecamatan')
		                             ->Where('alamat_user_aktif',1)
		                             ->Where('is_utama',1)
		                             ->Where('id_user',$this->user['id_user'])
		                             ->first();

		$ekspedisi_model = new EkspedisiModel();
		$ekspedisis = $ekspedisi_model->select('id_ekspedisi,uuid_ekspedisi, nama, tarif')
													->where('ekspedisi_aktif',1)
													->findAll();

		$id_order = $this->checkout(null);
		$orderModel = new OrderModel();
		$order = $orderModel->select('*')->where('id_order', $id_order)
		 								 ->first();		 								 
		
		if($order){
			$dpp = intVal($order['dpp']);
	    	$ppn = intVal($order['ppn']);
	    	$ongkir = 0;
	    	$total = $dpp + $ppn + $ongkir;	



	    	return view('order/pengiriman', [
	            'userData' => $this->userData,
	            'uuid_order'=>$order['uuid_order'],
	            'dpp'=>$dpp,
	            'ppn'=>$ppn,
	            'ongkir'=> $ongkir,
	            'total'=>$total,
	            'alamat'=>$alamat,
	            'ekspedisis' => $ekspedisis,
	        ]);
		}
	}

	public function bayar_midtrans($uuid_order){
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
		// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;

		$orderModel = new OrderModel();
		$order = $orderModel->select('*')->where('uuid_order', $uuid_order)
		 								 ->first();

		if ($order){
			$params = array(
			    'transaction_details' => array(
			        'order_id' => $uuid_order,
			        'gross_amount' => intVal($order['total']),
			    )
			);

			$snapToken = \Midtrans\Snap::getSnapToken($params);
			$url_redirect = "https://app.sandbox.midtrans.com/snap/v3/redirection/" . $snapToken;

			// Hapus item keranjang setelah berhasil disimpan dalam pesanan
			$cartModel = new CartModel();
            $hapus = $cartModel->where('id_user', $this->user['id_user'])->delete();
            if ($hapus){
	            	$data = [
			        'status' => true,	        
			        'url_redirect' =>$url_redirect,
			    ];	
            } else {
            	$data = [
			        'status' => false,	        
			        'pesan' =>'Gagal menghapus keranjang belanja',
			    ];
            }
		} else {
			$data = [
		        'status' => false,	        
		        'pesan' =>'Order tidak ditemukan',
		    ];
		}

		echo json_encode($data);
	}
	
	public function checkout($uuid_ekspedisi){

		$db = db_connect();
        $db->transBegin();

        try {
        	// $ekspedisiModel = new EkspedisiModel();
        	// $ekspedisi = $ekspedisiModel->select('*')
        	// 						  ->Where('uuid_ekspedisi', $uuid_ekspedisi) 
        	// 						  ->first();
        	// $ongkir = 0;
        	// if ($ekspedisi){
        	// 	$ongkir = $ekspedisi['tarif']; 
        	// } else {
        	// 	throw new \Exception("Ekspedisi belum dipilih");
        		
        	// }

        	$cartModel = new CartModel();
            $data_carts = $cartModel->select('b.nama as desain,b.id_desain,c.id_produk, b.url_desain, d.`name` as group_produk, c.color, c.color_name, c.url_image, e.size, e.harga, tb_cart.qty, tb_cart.uuid_cart, tb_cart.id_produk_size, tb_cart.id_cart, tb_cart.url_image')
    	                       ->join('m_desain b ', 'tb_cart.id_desain = b.id_desain')
    	                       ->join('m_produk c ', 'tb_cart.id_produk = c.id_produk')
    	                       ->join('m_group_produk d ', 'c.id_group_produk = d.id_group_produk')
    	                       ->join('m_produk_size e ', 'tb_cart.id_produk_size = e.id_produk_size')
    	                       ->Where('tb_cart.id_user',$this->user['id_user'])
    	                       ->orderby('tb_cart.created_at')
    	                       ->findAll();

	    	$data_summary = $this->get_data_summary_order();
	    	$dpp = intVal($data_summary['dpp']);
	    	$ppn = intVal($data_summary['ppn']);
	    	$total = intVal($data_summary['total']);

            // Simpan order

            $tgl_order   = new \DateTime();
            $tgl_order = $tgl_order->format('Y-m-d H:i:s');

            $orderModel = new OrderModel();
            $orderData = [
                'id_user' => $this->user['id_user'],
                'dpp' => $dpp,
                'ppn' => $ppn,
                // 'ongkir'=>$ongkir,
                'total' => $total,
                'status' => 'Dibuat',
                'tgl_order' => $tgl_order,
                // 'id_ekspedisi'=>$ekspedisi['id_ekspedisi'],                
            ];

            $orderModel->insert($orderData);
            $id_order = $orderModel->insertID();

            $orderDetailModel = new OrderDetailModel();
            foreach ($data_carts as $data_cart) {
            	$orderDetailData = [
                    'id_desain' => $data_cart['id_desain'],
                    'nama_desain' => $data_cart['desain'],
                    'id_produk' => $data_cart['id_produk'],
                    'nama_group_produk' => $data_cart['group_produk'],
                    'color' => $data_cart['color'],
                    'color_name' => $data_cart['color_name'],
                    'qty' => $data_cart['qty'],
                    'harga' => $data_cart['harga'],
                    'id_user' => $this->user['id_user'],
                    'id_produk_size' => $data_cart['id_produk_size'],
                    'size' => $data_cart['size'],
                    'id_order' => $id_order,
                    'url_image' => $data_cart['url_image'],
                ];
                
                $orderDetailModel->insert($orderDetailData);

                $this->update_stock_produk_size($data_cart['id_produk_size'], -1 * $data_cart['qty']);
                
                // echo $orderDetailModel->db->getLastQuery();
            	// die();
            }

            

            // Commit transaction jika tidak terjadi kesalahan
            $db->transCommit();

            return $id_order;



			

            // Redirect ke halaman pembayaran
            // return redirect()->to('/order/payment');

            
        } catch (\Exception $e) {
            // Rollback transaction jika terjadi kesalahan
            $db->transRollback();
            echo $e->getMessage();
            // return redirect()->to('/order/show_cart');
        }

        // $snapToken = $this->token_midtrans($id_order, $total);
        // $clientKey = 'SB-Mid-client-S-BXOnWMeAvtv-G3';
        // return view('order/midtrans', [
        //     'snapToken' => $snapToken,
        //     'clientKey' => $clientKey,
        // ]);

        // $snapToken = \Midtrans\Snap::getSnapToken($params);
        // return view('checkout', compact('snapToken','order'));

        // $this->bayar_midtrans($id_order, $total);
    }   

}