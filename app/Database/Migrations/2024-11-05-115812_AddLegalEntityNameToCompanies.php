<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLegalEntityNameToCompanies extends Migration
{
    public function up()
    {
        $this->forge->addColumn('companies', [
            'legal_entity_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'office_name'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('companies', 'legal_entity_name');
    }
}
