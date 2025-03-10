<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderExhibitsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
                'null'       => false,
            ],
            'origin' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 64,  // SHA-256 hash
                'null'       => false,
            ],
            'page_count' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('order_exhibits');
    }

    public function down()
    {
        $this->forge->dropTable('order_exhibits');
    }
}
