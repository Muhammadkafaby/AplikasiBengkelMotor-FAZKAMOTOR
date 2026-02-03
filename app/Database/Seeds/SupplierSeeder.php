<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [

        ];

        if (!empty($data)) {
            $this->db->table('suppliers')->insertBatch($data);
        }
    }
}
