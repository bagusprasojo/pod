<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupProdukModel;
use App\Models\ProdukModel;
use App\Models\DesainModel;
use App\Models\DesainGPModel;
// use Hermawan\DataTables;
use \Hermawan\DataTables\DataTable;

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

    private function add_desain_get(){
        
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

    public function add_desain(){
        if (strtoupper($this->request->getMethod()) === 'GET') {
            return $this->add_desain_get();
        } else {
            // var_dump($_POST);
            // die();

            $gambar = $this->request->getFile('gambarInput');
            $path = ROOTPATH . 'assets/desain/';
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


            $db = \Config\Database::connect();
            $db->transBegin();

            try {
                $desainModel = new DesainModel();
                $desainData = [
                    'nama' => esc($this->request->getPost('nama_desain')),
                    'tag' => esc($this->request->getPost('tag')),
                    'deskripsi' => esc($this->request->getPost('deskripsi')),
                    'url_desain' => $newName,
                    'desain_aktif' => 1, 
                    'status_aktif' => 'Aktif',
                    'id_user' => $this->user['id_user'],
                    
                ];

                $desainModel->insert($desainData);
                $idDesain = $desainModel->insertID();


                foreach ($_POST as $key => $value) {
                    if (strpos($key, 'cb_') === 0) {
                        $cbNumber = substr($key, 3);
                        $selectKey = 'select_' . $cbNumber;

                        // Periksa apakah elemen select tersedia
                        if (isset($_POST[$selectKey])) {
                            $desainGPModel = new DesainGPModel();
                            $desainGPData = [
                                'id_desain'=> $idDesain,
                                'id_group_produk'=> $_POST[$key],
                                'url'=> '',
                                'desain_gp_aktif' => 1,
                                'color'=> $_POST[$selectKey],

                            ];

                            // var_dump($desainGPData);
                            // die();

                            $desainGPModel->insert($desainGPData);
                            // echo $db->getLastQuery();
                            
                        }
                    }
                }

                $db->transCommit();

                return redirect()->to('/designer_dashboard/produk_list');
            
            } catch (\Exception $e) {
                $db->transRollback();
                return "Error: " . $e->getMessage();
            } 
        }

    }

    public function profile()
    {
        return view('designer/designer_profile', [
            'userData' => $this->userData,
            'statistics' => $this->statistics,
            'pager'=>$this->pager
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

    public function desain_list()
    {
        return view('designer/desain_list', [
            'userData' => $this->userData,
        ]);
    }

    public function desain_list_()
    {
        $desainModel    = new DesainModel();
        $button = "'" . '' . "'";

        $desainModel->select('id_desain,nama,deskripsi,tag,tag')->where('desain_aktif',1);

        return DataTable::of($desainModel)->toJson();
    }

}