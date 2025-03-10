<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToUser extends Migration
{
  
    public function up()
    {
        // Add new columns and drop 'currency' field from 'users' table
        $this->forge->addColumn('users', [
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'company_id', // Place the column after 'company_id'
            ],
            'country_a2code' => [
                'type'       => 'VARCHAR',
                'constraint' => '2',
                'null'       => true,
                'after'      => 'country',
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'country_a2code',
            ],
            'address_line_1' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'city',
            ],
            'address_line_2' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'address_line_1',
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'address_line_2',
            ],
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'after'      => 'state',
            ],
            'zip_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'after'      => 'province',
            ],
        ]);

        // Drop 'currency' column
        $this->forge->dropColumn('users', 'currency');
    }

    public function down()
    {
        // Rollback changes by adding 'currency' back and dropping the new columns
        $this->forge->addColumn('users', [
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
                'null'       => true,
            ],
        ]);

        $this->forge->dropColumn('users', [
            'country',
            'country_a2code',
            'city',
            'address_line_1',
            'address_line_2',
            'state',
            'province',
            'zip_code',
        ]);
    }
}
