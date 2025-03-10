<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ServiceFees extends Migration
{
    public function up()
    {
        $sql = "DROP TABLE IF EXISTS `service_fees`"; 
		$this->db->query($sql);			
		
        $sql = "CREATE TABLE `service_fees` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `report_type` enum('medical_chronology','billing_summary','medical_chronology_and_billing_summary') DEFAULT NULL,
  `pages_range` varchar(15) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 

		$this->db->query($sql);
		
		$sql = "ALTER TABLE `service_fees`
  ADD PRIMARY KEY (`id`);"; 

		$this->db->query($sql);
		
		$sql = "ALTER TABLE `service_fees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;"; 

		$this->db->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `service_fees`"; 
		$this->db->query($sql);	
    }
}
