<?php

namespace App\Models;

use CodeIgniter\Model;

class EkspedisiModel extends Model
{
    protected $table = 'm_ekspedisi';
    protected $primaryKey = 'id_ekspedisi';
    protected $allowedFields = ['nama', 'ekspedisi_aktif','uuid_ekspedisi']; // Field yang diizinkan untuk diisi
    protected $useAutoIncrement = true;
    
    // Aturan validasi, misalnya untuk pendaftaran pengguna
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';



    // Validation
    // protected $validationRules = [
    //     'ekspedisiname' => 'required|min_length[3]|max_length[20]|is_unique[m_ekspedisi.ekspedisiname]',
    //     'email' => 'required|valid_email|is_unique[m_ekspedisi.email]',
    //     'password' => 'required|min_length[8]',
    //     'name' => 'required',
        
    // ];
    
    // protected $validationMessages = [
    //     'ekspedisiname' => [
    //         'required' => 'ekspedisiname harus diisi.',
    //         'min_length' => 'ekspedisiname minimal terdiri dari 3 karakter.',
    //         'max_length' => 'ekspedisiname maksimal terdiri dari 20 karakter.',
    //         'is_unique' => 'ekspedisiname sudah digunakan, pilih yang lain.',
    //     ],
    //     'email' => [
    //         'required' => 'Email harus diisi.',
    //         'valid_email' => 'Email tidak valid.',
    //         'is_unique' => 'Email sudah terdaftar, gunakan email lain.',
    //     ],
    //     'password' => [
    //         'required' => 'Password harus diisi.',
    //         'min_length' => 'Password minimal terdiri dari 8 karakter.',
    //     ],
    //     'name' => [
    //         'required' => 'Nama harus diisi.',
            
    //     ],
    //     'name_designer' => [
    //         'required' => 'Nama designer harus diisi jika is_designer adalah 1.', // Pesan kesalahan untuk aturan validasi kustom
    //     ],
        
    // ];

    // public function validate($row):bool
    // {
    //     // Melakukan validasi secara manual
    //     if ($row['is_designer'] == 1 && empty($row['name_designer'])) {
    //         $this->validation->setError('name_designer', 'required');
    //         return false;
    //     }

    //     return parent::validate($row);
    // }

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
        
        $data['data']['uuid_ekspedisi'] = $uuid->toString();

        return $data;
    }
}
