<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'email' => 'admin@fazkamotor.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'name' => 'Administrator',
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'kasir',
                'email' => 'kasir@fazkamotor.com',
                'password' => password_hash('kasir123', PASSWORD_DEFAULT),
                'name' => 'Kasir 1',
                'role' => 'kasir',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('fm_users')->insertBatch($data);
    }
}
