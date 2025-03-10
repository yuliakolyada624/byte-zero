<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOrderStatusAndBillingFieldsToOrdersTable extends Migration
{
    public function up()
    {
        $fields = [
            'order_status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'ai_processing', 'ai_processed', 'reviewed', 'approved', 'shared'],
                'default'    => 'draft',
                'after'      => 'creater_user_id',
            ],
            'billed_amount' => [
                'type'       => 'FLOAT',
                'null'       => true,
                'after'      => 'checkout_session_id',
            ],
            'billed_currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 3,
                'null'       => true,
                'after'      => 'billed_amount',
            ],
        ];

        $this->forge->addColumn('orders', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('orders', 'order_status');
        $this->forge->dropColumn('orders', 'billed_amount');
        $this->forge->dropColumn('orders', 'billed_currency');
    }
}
