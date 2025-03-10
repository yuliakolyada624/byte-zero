<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNewFieldToCompaniesTable extends Migration
{
    public function up()
    {
        // Define the new column details
        $fields = [
            'domain' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'after'      => 'company_name',
            ],
        ];

        // Modify the table by adding the new field
        $this->forge->addColumn('companies', $fields);
    }

    public function down()
    {
        // Reverse the operation by removing the new field
        $this->forge->dropColumn('companies', 'domain');
    }
}
