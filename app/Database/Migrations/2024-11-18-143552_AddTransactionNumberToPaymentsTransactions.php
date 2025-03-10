<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransactionNumberToPaymentsTransactions extends Migration
{
    public function up()
    {
        // Define the new field to be added
        $fields = [
            'transaction_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'after'      => 'id',
            ],
        ];

        // Add the new field to the payments_transactions table
        $this->forge->addColumn('payments_transactions', $fields);

        // Add an index to the transaction_number field
        $this->db->query('ALTER TABLE `payments_transactions` ADD INDEX (`transaction_number`)');
    }

    public function down()
    {
        // Remove the transaction_number field from the payments_transactions table
        $this->forge->dropColumn('payments_transactions', 'transaction_number');
    }
}
