<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Budi Santoso',
                'phone' => '0812-1111-2222',
                'email' => 'budi@email.com',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ani Wijaya',
                'phone' => '0813-3333-4444',
                'email' => 'ani@email.com',
                'address' => 'Jl. Sudirman No. 25, Bekasi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Rizky Pratama',
                'phone' => '0857-5555-6666',
                'email' => null,
                'address' => 'Jl. Gatot Subroto No. 50',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('fm_customers')->insertBatch($data);
    }
}
