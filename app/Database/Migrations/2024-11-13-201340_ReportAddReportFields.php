<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ReportAddReportFields extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `order_reports` ADD `chronologies` TEXT NULL DEFAULT NULL AFTER `ai_cost`, ADD `synopsis` TEXT NULL DEFAULT NULL AFTER `chronologies`, ADD `assessment_codes` TEXT NULL DEFAULT NULL AFTER `synopsis`, ADD `visits_history` TEXT NULL DEFAULT NULL AFTER `assessment_codes`, ADD `billing_summary` TEXT NULL DEFAULT NULL AFTER `visits_history`, ADD `documents` TEXT NULL DEFAULT NULL AFTER `billing_summary`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `med-test`.`order_reports` ADD INDEX `order_number` (`order_number`(31)); "; 
		$this->db->query($sql);	
    }

    public function down()
    {
		$sql = "ALTER TABLE `order_reports`
		  DROP `chronologies`,
		  DROP `synopsis`,
		  DROP `assessment_codes`,
		  DROP `visits_history`,
		  DROP `billing_summary`,
		  DROP `documents`; "; 
  
		$this->db->query($sql);	
    }
}
