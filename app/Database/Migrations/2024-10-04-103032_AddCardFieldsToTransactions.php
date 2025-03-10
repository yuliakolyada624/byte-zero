<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCardFieldsToTransactions extends Migration
{
    public function up()
    {
        // Add new fields to the payments_transactions table
        $this->forge->addColumn('payments_transactions', [
            'card_type' => [
                'type' => 'ENUM',
                'constraint' => ['Visa', 'Mastercard', 'American Express'],
                'default' => 'Visa',
                'null' => false,
                'after' => 'authorization_currency'
            ],
            'card_ends_in' => [
                'type' => 'CHAR',
                'constraint' => 4,
                'null' => true, // 
                'after' => 'authorization_currency'
            ],
        ]);
    }

    public function down()
    {
        // Drop the added fields if the migration is rolled back
        $this->forge->dropColumn('payments_transactions', ['card_type', 'card_ends_in']);
    }
}
