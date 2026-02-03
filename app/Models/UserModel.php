<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'username',
        'email',
        'password',
        'name',
        'role',
        'avatar',
        'is_active'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'required|min_length[6]',
        'name' => 'required|min_length[3]|max_length[100]',
        'role' => 'required|in_list[admin,kasir]',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username wajib diisi',
            'is_unique' => 'Username sudah digunakan',
        ],
        'email' => [
            'required' => 'Email wajib diisi',
            'valid_email' => 'Format email tidak valid',
            'is_unique' => 'Email sudah digunakan',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Verify login credentials
     */
    public function verifyLogin(string $username, string $password): ?array
    {
        $user = $this->where('username', $username)
            ->where('is_active', 1)
            ->first();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return null;
    }

    /**
     * Hash password before insert
     */
    protected function beforeInsert(array $data): array
    {
        return $this->hashPassword($data);
    }

    /**
     * Hash password before update
     */
    protected function beforeUpdate(array $data): array
    {
        return $this->hashPassword($data);
    }

    /**
     * Hash password helper
     */
    protected function hashPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    protected $allowCallbacks = true;
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
}
