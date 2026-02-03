<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'fazkamotor',
                'email' => 'admin@fazkamotor.com',
                'password' => password_hash('fazkamotorjatibarang', PASSWORD_DEFAULT),
                'name' => 'Administrator',
                'role' => 'admin',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'fazkamotorkasir',
                'email' => 'kasir@fazkamotor.com',
                'password' => password_hash('azkamotorjatibarangkasir', PASSWORD_DEFAULT),
                'name' => 'Kasir 1',
                'role' => 'kasir',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
