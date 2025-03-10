<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderReportsChanges extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `order_reports` CHANGE `order_id` `order_number` VARCHAR(31) NULL DEFAULT NULL; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` CHANGE `ml_processed` `ai_processed` TINYINT(1) NULL DEFAULT '0';  "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` CHANGE `ml_cost` `ai_cost` DECIMAL(10,2) UNSIGNED NOT NULL DEFAULT '0.00'; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` DROP `ml_processing_start_time`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` DROP `ml_processing_end_time`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` DROP `editing_start_time`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` DROP `editing_end_time`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` DROP `editor_user_id`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` DROP `editor_cost`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports` ADD `created_at` DATETIME NULL DEFAULT CURRENT_TIMESTAMP AFTER `ai_cost`; "; 
		$this->db->query($sql);	
    }

    public function down()
    {
        //
    }
}
