<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOfficeNameToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'office_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true, 
                'after' => 'company_id',
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // Drop the office_name column if it exists
        $this->forge->dropColumn('users', 'office_name');
    }
}
