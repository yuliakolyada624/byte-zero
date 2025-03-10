<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class JobTitles extends Migration
{
    public function up()
    {
		$sql = "DROP TABLE IF EXISTS `job_titles`"; 
		$this->db->query($sql);		
		
        $sql = "CREATE TABLE `job_titles` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `job_title` varchar(127) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 

		$this->db->query($sql);
		
		$sql = "ALTER TABLE `job_titles`
  ADD PRIMARY KEY (`id`);"; 

		$this->db->query($sql);
		
		$sql = "ALTER TABLE `job_titles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;"; 

		$this->db->query($sql);
    }

    public function down()
    {
        $sql = "DROP TABLE IF EXISTS `job_titles`"; 
		$this->db->query($sql);	
    }
}
