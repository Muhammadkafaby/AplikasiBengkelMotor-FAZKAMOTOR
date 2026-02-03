<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [

        ];

        if (!empty($data)) {
            $this->db->table('customers')->insertBatch($data);
        }
    }
}
