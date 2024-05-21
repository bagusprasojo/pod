<?php

namespace App\Controllers\user;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\GroupProdukModel;
use App\Models\ProdukModel;
use App\Models\DesainModel;
use App\Models\DesainGPModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;


use \Hermawan\DataTables\DataTable;

class UserDashboard extends BaseController
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

    public function index()
    {

        return view('user/user_data_diri', [
            'userData' => $this->userData,
            'statistics' => $this->statistics,
            'pager'=>$this->pager
        ]);
    }

    private function getOrderDetails($orders){
        $id_orders = [];

        foreach ($orders as $order) {
            $id_orders[] = $order['id_order'];
        }

        $orderModelDetail    = new OrderDetailModel();    


        $orderDetails = $orderModelDetail->select('tb_order_detail.*')
                                         ->whereIn('id_order', $id_orders)->findAll();

        return $orderDetails;

    }

    private function getModelOrder($status, $filter_data, $filter_tgl) : OrderModel{
        $tgl1 = substr($filter_tgl, 0,10);
        $tgl1 = substr($tgl1,6,4) . '-' . substr($tgl1,0,2) . '-' . substr($tgl1,3,2);


        $tgl2 = substr($filter_tgl, 13,10);
        $tgl2 = substr($tgl2,6,4) . '-' . substr($tgl2,0,2) . '-' . substr($tgl2,3,2); 

        $orderModel    = new OrderModel();

        // echo $status . "<br>";
        // echo $filter_data . "<br>";
        // echo $filter_tgl . "<br>";

        

        $orderModel->distinct()->select('tb_order.id_order,date(tb_order.tgl_order) as tgl_order,tb_order.status,tb_order.total, b.nama as ekspedisi')
                               ->join('m_ekspedisi b','tb_order.id_ekspedisi = b.id_ekspedisi')
                               ->join('tb_order_detail c', 'tb_order.id_order = c.id_order ')
                               ->orderby('tb_order.tgl_order desc');

        if ($tgl1){
            $orderModel->where('date(tb_order.tgl_order) >=', $tgl1);
        }

        if ($tgl2){
            $orderModel->where('date(tb_order.tgl_order) <=', $tgl2);
        }

        if ($status != 'Semua'){
            $orderModel->where('tb_order.status =', $status);            
        }

        if ($filter_data){
            $orderModel->groupStart() 
                        ->like('b.nama', $filter_data)
                        ->orLike('c.nama_desain', $filter_data)
                        ->groupEnd();
        }

        return $orderModel;

    }

    public function transaksi()
    {
        $status = $this->request->getGet('status');
        if ($status == ''){
            $status = 'Semua';
        }

        
        $filter_data = $this->request->getGet('filter_data');
        
        $filter_tgl = $this->request->getGet('filter_tgl');
        if ($filter_tgl == ''){
            $date   = new \DateTime(); //this returns the current date time
            $tgl1 = $date->format('m-d-Y');
            $tgl2 = $date->format('m-d-Y');

            $filter_tgl =  $tgl1 . ' - ' . $tgl2;
        }

        $orderModel = $this->getModelOrder($status, $filter_data, $filter_tgl);
        $orders = $orderModel->paginate(3);
        $pager = $orderModel->pager;

        $orderDetails = $this->getOrderDetails($orders);

        // echo $orderModel->db->getLastQuery();

        // var_dump($orders);
        // die();


        return view('user/user_transaksi', [
            'userData' => $this->userData,
            'statistics' => $this->statistics,
            'filter_data' =>$filter_data,
            'filter_tgl' => $filter_tgl,
            'status' => $status,
            'pager'=>$pager,
            'orders' => $orders,
            'orderDetails' => $orderDetails,
        ]);
    }

    public function transaksi_list_()
    {
        $orderModel    = new OrderModel();
        

        $orders = $orderModel->select('tb_order.*')->join('tb_order_detail b','tb_order.id_order=b.id_order')
                                                   ->paginate(5);

        $pager = $orderModel->pager;

        return view("user_transaksi", $data);
    }

}