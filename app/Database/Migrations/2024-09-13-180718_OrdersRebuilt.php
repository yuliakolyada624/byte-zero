<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrdersRebuilt extends Migration
{
    public function up()
    {
		$sql = "DROP TABLE `orders`"; 
		$this->db->query($sql);	
		
        $sql = "CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `creater_user_id` int(10) UNSIGNED DEFAULT NULL,
  `checkout_session_id` varchar(31) DEFAULT NULL,
  `order_number` varchar(31) DEFAULT NULL,
  `claim_type` enum('body_injury','disability_claim','nurcsing_home_negligence','workers_compensation') DEFAULT NULL,
  `report_type` enum('medical_chronology','billing_summary','medical_chronology_and_billing_summary') DEFAULT NULL,
  `claim_number` varchar(31) DEFAULT NULL,
  `case_name` varchar(127) DEFAULT NULL,
  `plaintiff_first_name` varchar(63) DEFAULT NULL,
  `plaintiff_last_name` varchar(63) DEFAULT NULL,
  `plaintiff_dob` datetime DEFAULT NULL,
  `plaintiff_gender` enum('male','female') DEFAULT NULL,
  `defendant_first_name` varchar(127) DEFAULT NULL,
  `defendant_last_name` varchar(127) DEFAULT NULL,
  `defendant_company_name` varchar(127) DEFAULT NULL,
  `date_of_incident` datetime DEFAULT NULL,
  `location_of_accident` varchar(127) DEFAULT NULL,
  `injury_areas` set('head_and_neck','upper_extremity','torso','back','lower_extremity','internal_organs','skin','circulatory_and_nervous_systems') DEFAULT NULL,
  `exhibit_count` mediumint(8) UNSIGNED DEFAULT NULL,
  `page_count` mediumint(8) UNSIGNED DEFAULT NULL,
  `time_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `time_paid` datetime DEFAULT NULL,
  `time_ml_processed` datetime DEFAULT NULL,
  `reviewer_user_id` int(10) UNSIGNED DEFAULT NULL,
  `time_fully_reviewed` datetime DEFAULT NULL,
  `fully_reviewed` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `approver_user_id` int(10) UNSIGNED DEFAULT NULL,
  `time_approval` datetime DEFAULT NULL,
  `approved` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `approval_notice_for_reviewer` text DEFAULT NULL,
  `time_due` datetime DEFAULT NULL COMMENT 'time when report should be ready for customer',
  `number_of_downloads` mediumint(8) UNSIGNED NOT NULL DEFAULT 0,
  `time_last_download` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);"; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;"; 
		$this->db->query($sql);	
    }

    public function down()
    {
        //
    }
}
