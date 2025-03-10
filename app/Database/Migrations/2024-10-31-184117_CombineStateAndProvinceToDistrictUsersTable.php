<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CombineStateAndProvinceToDistrictUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'district' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
                'after' => 'province',
            ],
        ]);

        $this->db->query("
            UPDATE users 
            SET district = CONCAT_WS(' ', state, province)
        ");

        $this->forge->dropColumn('users', 'state');
        $this->forge->dropColumn('users', 'province');
    }

    public function down()
    {
        $this->forge->addColumn('users', [
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => 64,
                'null' => true,
            ],
        ]);

        $this->db->query("
            UPDATE users 
            SET state = SUBSTRING_INDEX(district, ' ', 1),
                province = SUBSTRING_INDEX(district, ' ', -1)
            WHERE district IS NOT NULL
        ");

        $this->forge->dropColumn('users', 'district');
    }
}
