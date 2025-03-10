<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateEnumValueInOrdersTable extends Migration
{
    public function up()
    {
        // Modify the enum values in the `claim_type` column
        $this->forge->modifyColumn('orders', [
            'claim_type' => [
                'type' => 'ENUM',
                'constraint' => ['bodily_injury', 'disability_claim', 'nursing_home_negligence', 'medical_malpractice', 'workers_compensation'], // Update enum values as needed
                'null' => true,
                'default' => null,
            ],
        ]);
    }

    public function down()
    {
        // Revert the enum values in the `claim_type` column back to the original set
        $this->forge->modifyColumn('orders', [
            'claim_type' => [
                'type' => 'ENUM',
                'constraint' => ['body_injury', 'disability_claim', 'nurcsing_home_negligence', 'medical_malpractice', 'workers_compensation'], // Original enum values
                'null' => true,
                'default' => null,
            ],
        ]);
    }
}
