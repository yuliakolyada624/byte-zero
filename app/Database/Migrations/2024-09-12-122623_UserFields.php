<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserFields extends Migration
{
    public function up()
    {
        // Add new columns
        $this->forge->addColumn('users', [
            'phone_number_code' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
                'after' => 'phone_number',
            ],
            'phone_number_country' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
                'after' => 'phone_number',
            ],
            'work_phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
                'after' => 'phone_number',
            ],
            'work_phone_number_code' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
                'after' => 'work_phone_number',
            ],
            'work_phone_number_country' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
                'after' => 'work_phone_number_code',
            ],
            'user_status' => [
                'type' => 'ENUM',
                'constraint' => ['Registered', 'Invited', 'Suspended'],
                'null' => true,
                'default' => 'Registered',
            ],
            'job_title' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'last_updated' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'registered_on' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'last_password_update' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'password_change_frequency' => [
                'type' => 'ENUM',
                'constraint' => ['3 months', '6 months', '12 months'],
                'null' => true,
                'default' => '12 months',
            ],
            'permanently_delete_notifications_older_than' => [
                'type' => 'ENUM',
                'constraint' => ['1 month', '3 months', '6 months', '12 months'],
                'null' => true,
                'default' => '12 months',
            ],
        ]);

        // Drop unnecessary columns
        $this->forge->dropColumn('users', [
            'language',
            'middle_name',
            'country',
            'city',
            'nationality',
            'office_id',
            'state',
            'province',
            'zip_code',
            'postal_code',
            'address_line_1',
            'role_id',
            'department_id',
            'custom_tpt',
            'exclude_notifications_from_header',
            'email_notifications_for_missed_alerts',
        ]);

        
    }

    public function down()
    {
       

        // Rollback the changes by removing added columns
        $this->forge->dropColumn('users', [
            'phone_number_code',
            'phone_number_country',
            'work_phone_number',
            'work_phone_number_code',
            'work_phone_number_country',
            'user_status',
            'job_title',
            'last_login',
            'last_updated',
            'registered_on',
            'last_password_update',
            'password_change_frequency',
            'permanently_delete_notifications_older_than',
        ]);

        // Add back dropped columns
        $this->forge->addColumn('users', [
            'language' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'middle_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'country' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'nationality' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'office_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'state' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'province' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'zip_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'postal_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'address_line_1' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'department_id' => [
                'type' => 'INT',
                'null' => true,
            ],
            'custom_tpt' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'exclude_notifications_from_header' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
            ],
            'email_notifications_for_missed_alerts' => [
                'type' => 'TINYINT',
                'constraint' => '1',
                'null' => true,
            ],
        ]);

    }
}
