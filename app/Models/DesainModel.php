<?php

namespace App\Models;

use CodeIgniter\Model;

class DesainModel extends Model
{
    protected $table = 'm_desain';
    protected $primaryKey = 'id_desain';
    protected $allowedFields = ['id_user', 'nama','tag','deskripsi','url_desain','desain_aktif','slug','status_aktif']; // Field yang diizinkan untuk diisi
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
    protected $beforeInsert   = ['generateSlug'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function generateSlug(array $data)
    {
        $slug = url_title($data['data']['nama'], '-', true) . '-' . date('YmdHis');
        $data['data']['slug'] = $slug;

        return $data;
    }
}
