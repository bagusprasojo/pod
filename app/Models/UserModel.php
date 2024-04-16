<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'm_user';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['username', 'email', 'password','name','address','follower_count', 'following_count','is_designer','name_designer']; // Field yang diizinkan untuk diisi
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
        'username' => 'required|min_length[3]|max_length[20]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
        'name' => 'required',
        
    ];
    
    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi.',
            'min_length' => 'Username minimal terdiri dari 3 karakter.',
            'max_length' => 'Username maksimal terdiri dari 20 karakter.',
            'is_unique' => 'Username sudah digunakan, pilih yang lain.',
        ],
        'email' => [
            'required' => 'Email harus diisi.',
            'valid_email' => 'Email tidak valid.',
            'is_unique' => 'Email sudah terdaftar, gunakan email lain.',
        ],
        'password' => [
            'required' => 'Password harus diisi.',
            'min_length' => 'Password minimal terdiri dari 8 karakter.',
        ],
        'name' => [
            'required' => 'Nama harus diisi.',
            
        ],
        'name_designer' => [
            'required' => 'Nama designer harus diisi jika is_designer adalah 1.', // Pesan kesalahan untuk aturan validasi kustom
        ],
        
    ];

    public function validate($row):bool
    {
        // Melakukan validasi secara manual
        if ($row['is_designer'] == 1 && empty($row['name_designer'])) {
            $this->validation->setError('name_designer', 'required');
            return false;
        }

        return parent::validate($row);
    }

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
