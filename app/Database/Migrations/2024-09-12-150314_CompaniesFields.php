<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CompaniesFields extends Migration
{
    public function up()
    {
        // Drop unnecessary columns
        $this->forge->dropColumn('companies', [
            'default_tpt_value',
            'state_province_of_registration',
            'federal_tax_id_ein',
            'state_provincial_regional_tax_id',
            'first_name',
            'last_name',
            'phone_number',
            'email',
            'work_phone_number_dialcode',
            'work_phone_number',
            'mobile_phone_dialcode',
            'mobile_phone_number',
            'number_of_employees',
            'annual_booking_budget_estimate',
            'trips_prefix',
            'trips_number',
        ]);

        // Add new columns
        $this->forge->addColumn('companies', [
            
            'office_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'after' => 'company_name',
            ],
            'time_format' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'after' => 'job_title',
            ],
            'time_zone' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'after' => 'job_title',
            ],
            'daylight_savings' => [
                'type' => 'BOOLEAN',
                'null' => true,
                'default' => false,
                'after' => 'job_title',
            ],
            'notifications_copy_email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'job_title',
            ],
            'alert_superadmin_when_payment_method_nears_expiration' => [
                'type' => 'BOOLEAN',
                'null' => true,
                'default' => false,
                'comment' => 'Alert Superadmin when payment method nears expiration',
                'after' => 'job_title',
            ],
            'service_industry' => [
                'type' => 'ENUM',
                'constraint' => ['Healthcare Services', 'Insurance Services', 'Legal Services'],
                'null' => true,
                'after' => 'job_title',
            ],
        ]);
    }

    public function down()
    {
        // Rollback the changes by removing added columns
        $this->forge->dropColumn('companies', [
            'office_name',
            'time_format',
            'time_zone',
            'daylight_savings',
            'notifications_copy_email',
            'alert_superadmin_when_payment_method_nears_expiration',
            'service_industry',
        ]);

        // Add back dropped columns
        $this->forge->addColumn('companies', [
            'default_tpt_value' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'state_province_of_registration' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'federal_tax_id_ein' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'state_provincial_regional_tax_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'last_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'work_phone_number_dialcode' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
            ],
            'work_phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'mobile_phone_dialcode' => [
                'type' => 'VARCHAR',
                'constraint' => '5',
                'null' => true,
            ],
            'mobile_phone_number' => [
                'type' => 'VARCHAR',
                'constraint' => '15',
                'null' => true,
            ],
            'number_of_employees' => [
                'type' => 'INT',
                'null' => true,
            ],
            'annual_booking_budget_estimate' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'trips_prefix' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'trips_number' => [
                'type' => 'INT',
                'null' => true,
            ],
        ]);
    }
}
