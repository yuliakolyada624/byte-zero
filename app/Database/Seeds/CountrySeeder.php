<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $this->db->table('countries')->update(['active' => 0]);

        $this->db->table('countries')
            ->whereIn('alpha2', ['US', 'CA'])
            ->update(['active' => 1]);
    }
}
