<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MultipleTablesUpdate extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `payments_transactions` ADD `order_id` INT UNSIGNED NULL DEFAULT NULL AFTER `user_id`; "; 
		$this->db->query($sql);
		
		$sql = "ALTER TABLE `payments_transactions` ADD `is_refund` TINYINT(1) UNSIGNED NULL DEFAULT NULL AFTER `payment_card_data`; "; 
		$this->db->query($sql);
		
		$sql = "ALTER TABLE `payment_cards` CHANGE `expiration_date` `expiration_date` DATE NULL DEFAULT NULL COMMENT 'This need only for card expiration notification by email. It should be only 1 day of the month.'; "; 
		$this->db->query($sql);
		
		$sql = "ALTER TABLE `notifications` CHANGE `status` `status` TINYINT(2) NOT NULL DEFAULT '0' COMMENT '0 - unread, 1 - delivered, 2 - read';"; 
		$this->db->query($sql);
		
		$sql = "ALTER TABLE `notifications` ADD `read_at` DATETIME NULL DEFAULT NULL AFTER `status`;"; 
		$this->db->query($sql);
		
		$sql = "ALTER TABLE `notifications` CHANGE `type` `type` VARCHAR(127) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;"; 
		$this->db->query($sql);
    }

    public function down()
    {
        // Remove the 'order_id' column from 'payments_transactions' table
        $sql = "ALTER TABLE `payments_transactions` DROP COLUMN `order_id`;";
        $this->db->query($sql);

        // Remove the 'is_refund' column from 'payments_transactions' table
        $sql = "ALTER TABLE `payments_transactions` DROP COLUMN `is_refund`;";
        $this->db->query($sql);

        // Revert the 'expiration_date' column in 'payment_cards' table to its previous state
        $sql = "ALTER TABLE `payment_cards` CHANGE `expiration_date` `expiration_date` DATE NOT NULL;";
        $this->db->query($sql);

        // Revert the 'status' column in 'notifications' table to its previous state
        $sql = "ALTER TABLE `notifications` CHANGE `status` `status` TINYINT(1) NOT NULL DEFAULT '0';";
        $this->db->query($sql);

        // Remove the 'read_at' column from 'notifications' table
        $sql = "ALTER TABLE `notifications` DROP COLUMN `read_at`;";
        $this->db->query($sql);

        // Revert the 'type' column in 'notifications' table to its previous state
        $sql = "ALTER TABLE `notifications` CHANGE `type` `type` VARCHAR(127) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
        $this->db->query($sql);
    }

}
