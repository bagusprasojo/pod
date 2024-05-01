<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'm_produk';
    protected $primaryKey = 'produk_id';
    protected $allowedFields = ['id_group_produk','url_image','color','color_name','produk_aktif']; // Field yang diizinkan untuk diisi
    protected $useAutoIncrement = true;
    
    // Aturan validasi, misalnya untuk pendaftaran pengguna
    
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Di dalam model ProdukSizeModel
    public function getProdukById($id_produk)
    {
        echo $id_produk;
                // die();

        $produk = $this->select('b.name as produk_group_name, color,color_name')
                    ->join('m_group_produk b', 'm_produk.id_group_produk = b.id_group_produk')
                    ->where('id_produk', $id_produk)->findAll();

        echo $cartModel->db->getLastQuery();
        die();
        return $produk;
    }
}
