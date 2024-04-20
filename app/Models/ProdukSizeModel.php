<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukSizeModel extends Model
{
    protected $table = 'm_produk_size';
    protected $primaryKey = 'id_produk_size';
    protected $allowedFields = ['id_produk','size','stock','harga','produk_size_aktif','urutan']; // Field yang diizinkan untuk diisi
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
}
