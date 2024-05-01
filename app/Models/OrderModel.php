<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class orderModel extends Model
{
    protected $table = 'tb_order';
    protected $primaryKey = 'id_order';
    protected $allowedFields = ['id_user','id_ekspedisi','dpp', 'ppn','ongkir','total','status','uuid_order',]; // Field yang diizinkan untuk diisi
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
        
        $data['data']['uuid_order'] = $uuid->toString();

        return $data;
    }
    
}


