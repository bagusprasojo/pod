<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class OrderDetailModel extends Model
{
    protected $table = 'tb_order_detail';
    protected $primaryKey = 'id_order_detail';
    protected $allowedFields = ['id_desain','nama_desain', 'id_produk','nama_group_produk','color','color_name','qty','harga','id_user','id_produk_size','size','uuid_order_detail','id_order','url_image']; // Field yang diizinkan untuk diisi
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
    protected $beforeInsert   = ['generateUUID'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function generateUUID(array $data)
    {
        $uuid = Uuid::uuid4(); // Membuat UUID versi 4 (random)
        
        $data['data']['uuid_order_detail'] = $uuid->toString();

        return $data;
    }
    
}


