<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderReports extends Migration
{
    public function up()
    {
		$sql = "DROP TABLE IF EXISTS `order_reports`";
		$this->db->query($sql);	
		
        $sql = "CREATE TABLE `order_reports` (
  `report_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `report_name` varchar(127) DEFAULT NULL,
  `system_report` tinyint(1) DEFAULT NULL,
  `editing_start_time` datetime NOT NULL,
  `editing_end_time` datetime NOT NULL,
  `editor_user_id` int(10) UNSIGNED NOT NULL,
  `editor_cost` decimal(10,2) UNSIGNED DEFAULT 0.00,
  `ml_processed` tinyint(1) DEFAULT 0,
  `ml_processing_start_time` datetime NOT NULL,
  `ml_processing_end_time` datetime NOT NULL,
  `ml_cost` decimal(10,2) UNSIGNED NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports`
  ADD PRIMARY KEY (`report_id`);"; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `order_reports`
  MODIFY `report_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;"; 
		$this->db->query($sql);	
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `order_reports`";
		$this->db->query($sql);	
    }
}
