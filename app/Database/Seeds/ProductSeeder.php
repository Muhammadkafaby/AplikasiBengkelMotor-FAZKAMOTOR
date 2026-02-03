<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Oli & Pelumas

        ];

        if (!empty($data)) {
            $this->db->table('products')->insertBatch($data);
        }
    }
}
