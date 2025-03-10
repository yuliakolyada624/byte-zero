<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CardsTimestamps extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `payment_cards` CHANGE `created_date` `created_at` DATETIME NULL DEFAULT NULL; "; 
		$this->db->query($sql);		
		
		$sql = "ALTER TABLE `payment_cards` CHANGE `updated_date` `updated_at` DATETIME NULL DEFAULT NULL; "; 
		$this->db->query($sql);		
		
		$sql = "ALTER TABLE `payment_cards` CHANGE `deleted_date` `deleted_at` DATETIME NULL DEFAULT NULL;"; 
		$this->db->query($sql);		
    }

    public function down()
    {
        $sql = "ALTER TABLE `payment_cards` CHANGE `created_at` `created_date` DATETIME NULL DEFAULT NULL; "; 
		$this->db->query($sql);		
		
		$sql = "ALTER TABLE `payment_cards` CHANGE `updated_at` `updated_date` DATETIME NULL DEFAULT NULL; "; 
		$this->db->query($sql);		
		
		$sql = "ALTER TABLE `payment_cards` CHANGE `deleted_at` `deleted_date` DATETIME NULL DEFAULT NULL;"; 
		$this->db->query($sql);		
    }
}
