<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSmsCodeToUsers extends Migration
{
    public function up()
    {
        // Add new fields sms_code and sms_expires_at
        $this->forge->addColumn('users', [
            'sms_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
                'null'       => true,
                'comment'    => 'Verification code for SMS',
            ],
            'sms_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Expiration time for the SMS code',
            ],
        ]);
    }

    public function down()
    {
        // Remove the fields in case of rollback
        $this->forge->dropColumn('users', 'sms_code');
        $this->forge->dropColumn('users', 'sms_expires_at');
    }
}
