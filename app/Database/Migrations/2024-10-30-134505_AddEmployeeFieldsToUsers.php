<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmployeeFieldsToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'employee_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'after'      => 'job_title',
                'null'       => true,
            ],
            'last_suspension' => [
                'type'       => 'DATETIME',
                'after'      => 'last_password_update',
                'null'       => true,
            ],
            'last_reactivation' => [
                'type'       => 'DATETIME',
                'after'      => 'last_suspension',
                'null'       => true,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['employee_id', 'last_suspension', 'last_reactivation']);
    }
}
