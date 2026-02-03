<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'PT. Honda Motor Parts',
                'phone' => '021-12345678',
                'email' => 'supplier@hondaparts.co.id',
                'address' => 'Jl. Industri Raya No. 123, Jakarta',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'CV. Yamaha Sparepart',
                'phone' => '021-87654321',
                'email' => 'info@yamahaparts.co.id',
                'address' => 'Jl. Otomotif No. 456, Bekasi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Toko Oli Sejahtera',
                'phone' => '0812-3456-7890',
                'email' => 'olisejahtera@gmail.com',
                'address' => 'Jl. Pasar Baru No. 78, Tangerang',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('fm_suppliers')->insertBatch($data);
    }
}
