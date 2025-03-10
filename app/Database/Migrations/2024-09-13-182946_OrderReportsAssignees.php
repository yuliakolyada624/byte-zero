<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrderReportsAssignees extends Migration
{
    public function up()
    {
		$sql = "DROP TABLE IF EXISTS `order_reports_assignees`"; 
		$this->db->query($sql);			
		
        $sql = "CREATE TABLE `order_reports_assignees` (
		  `report_id` int(10) UNSIGNED DEFAULT NULL,
		  `order_id` int(10) UNSIGNED DEFAULT NULL,
		  `user_id` int(10) UNSIGNED DEFAULT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 

		$this->db->query($sql);
    }
	
		

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `order_reports_assignees`"; 
		$this->db->query($sql);
    }
}
