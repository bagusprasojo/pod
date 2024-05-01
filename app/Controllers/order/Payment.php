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

class Payment extends BaseController
{
	public function callback(){
		$json_data = file_get_contents('php://input');



		// Mendekodekan data JSON menjadi array atau objek
		$data = json_decode($json_data, true);

		$transaction_status = $data['transaction_status'];
		$serverKey = $_ENV['MIDTRANS_SERVER_KEY'];
		$uuid_order = $data['order_id'];
		$status_code = $data['status_code'];
		$gross_amount = $data['gross_amount'];
		$signature_key = $data['signature_key'];



        $hashed = hash("sha512",$uuid_order.$status_code.$gross_amount.$serverKey);
        
        $lanjut = false;
        if ($hashed == $signature_key){
			$lanjut = true;

			if ($transaction_status == 'settlement' && $status_code == 200){
				$status_pesanan = 'Selesai';				
			} else if ($transaction_status == 'pending' && $status_code == 201){
				$status_pesanan = 'Menunggu Pembayaran';
				$uuid_order = $data['order_id'];
			}
		}

		if ($lanjut){		

			$orderModel = new OrderModel();
			$order = $orderModel->select('*')
			                    ->Where('uuid_order', $uuid_order)
			                    ->first();

			$orderModel->update($order['id_order'], ['status' => $status_pesanan]);

			echo $status_pesanan;
			die();
		}
        
	}

}