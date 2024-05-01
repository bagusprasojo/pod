<?php

namespace App\Models;

use CodeIgniter\Model;

class AlamatUserModel extends Model
{
    protected $table = 'm_alamat_user';
    protected $primaryKey = 'id_alamat_user';
    protected $allowedFields = ['label','id_user','id_propinsi', 'id_kabupaten', 'id_kecamatan','kode_pos','alamat','alamat_user_aktif', 'is_utama','uuid_alamat_user']; // Field yang diizinkan untuk diisi
    protected $useAutoIncrement = true;
    
    // Aturan validasi, misalnya untuk pendaftaran pengguna
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';



    // Validation
    protected $validationRules = [
        'label' => 'required',
        'id_propinsi' => 'required',
        'id_kabupaten' => 'required',
        'id_kecamatan' => 'required',
        'kode_pos' => 'required',
        'alamat' => 'required',
        
    ];
    
    protected $validationMessages = [
        'label' => [
            'required' => 'Label Alamat harus diisi.',
            
        ],'id_propinsi' => [
            'required' => 'Propinsi harus diisi.',
            
        ],
        'id_kabupaten' => [
            'required' => 'Kabupaten harus diisi.',
            
        ],
        'id_kecamatan' => [
            'required' => 'Kecamatan harus diisi.',
            
        ],
        'kode_pos' => [
            'required' => 'Kode Pos harus diisi.',
            
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi.',
            
        ],
        
    ];

    

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
        
        $data['data']['uuid_alamat_user'] = $uuid->toString();

        return $data;
    }
}
