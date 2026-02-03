<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Seed Users
        $this->call('UserSeeder');

        // Seed Categories
        $this->call('CategorySeeder');


    }
}
