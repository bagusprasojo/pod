<?php

namespace App\Controllers;

use App\Models\DesainModel;
use App\Models\DesainGPModel;
use App\Models\ProdukModel;
use App\Models\ProdukSizeModel;

class Home extends BaseController
{
    public function index(): string
    {
        $id_group_produk = 1;

        $nilai_search = '';
        if (isset($_GET['search'])) {
            $nilai_search = esc($_GET['search']);
        }

        $desainModel = new DesainModel();
        $desains = $desainModel->select('m_desain.id_desain,m_desain.slug, d.name as user, m_desain.nama,c.url_image, c.color, url_desain, b.id_group_produk, b.id_desain_gp,b.uuid_desain_gp, min(e.harga) as harga_min, max(e.harga) as harga_max')
                               ->join('m_desain_gp b', 'b.id_desain = m_desain.id_desain') 
                               ->join('m_produk c', 'b.id_group_produk = c.id_group_produk and b.color = c.color')
                               ->join('m_user d', 'd.id_user = m_desain.id_user') 
                               ->join('m_produk_size e ', 'c.id_produk = e.id_produk')
                               ->where('desain_aktif',1)
                               ->where('desain_gp_aktif',1)
                               ->where('b.id_group_produk',$id_group_produk)
                               ->groupBy('m_desain.id_desain, m_desain.slug, d.name, m_desain.nama, c.url_image, c.color, url_desain, b.id_group_produk, b.id_desain_gp, b.uuid_desain_gp') 
                               ->paginate(6);

        $pager = $desainModel->pager;

        // foreach ($desains as $desain) {
        //     echo $desain['nama'] . "<br>";
        // }

        // echo $desainModel->db->getLastQuery()->getQuery();
        // die();

        return view('index', ['desains' => $desains,'pager' => $pager ]);
    }

    public function produk_size_list_($id_produk)
    {
        $produkSizeModel = new ProdukSizeModel();
        $produkSizes = $produkSizeModel->select('id_produk_size, size, stock, harga')
                                       ->where('id_produk',$id_produk)
                                       ->where('produk_size_aktif',1)
                                       ->orderby('urutan')
                                       ->findAll();

        return json_encode($produkSizes);
    }

    public function detail($uuid_desain_gp){
        $desainGPModel = new DesainGPModel();
        $desain = $desainGPModel->select('m_desain_gp.*,b.nama as judul,b.deskripsi, b.url_desain, c.url_image, d.name')
                               ->where('uuid_desain_gp',$uuid_desain_gp)
                               ->join('m_desain b', 'b.id_desain = m_desain_gp.id_desain')
                               ->join('m_produk c', 'm_desain_gp.id_group_produk = c.id_group_produk and m_desain_gp.color = c.color')
                               ->join('m_user d','b.id_user = d.id_user')
                               ->first();

        $produkModel = new ProdukModel();
        $colors = $produkModel->select('color,color_name,url_image,id_produk')
                              ->Where('id_group_produk', $desain['id_group_produk'])
                              ->where('produk_aktif',1)
                              ->findAll();

        

         // echo $desainGPModel->db->getLastQuery()->getQuery();
         // die();              

        return view('produk_detail', ['desain' => $desain,'colors'=>$colors, ]);

                               
        
    }
}
