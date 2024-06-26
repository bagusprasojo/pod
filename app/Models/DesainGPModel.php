<?php

namespace App\Models;

use CodeIgniter\Model;
use Ramsey\Uuid\Uuid;

class DesainGPModel extends Model
{
    protected $table = 'm_desain_gp';
    protected $primaryKey = 'id_desain_gp';
    protected $allowedFields = ['id_desain','id_group_produk', 'url','color','desain_gp_aktif','uuid_desain_gp']; // Field yang diizinkan untuk diisi
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
        
        $data['data']['uuid_desain_gp'] = $uuid->toString();

        return $data;
    }

    
}
