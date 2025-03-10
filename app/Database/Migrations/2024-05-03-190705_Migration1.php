<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Migration1 extends Migration
{
    public function up()
    {
        $sql = "ALTER TABLE `payment_cards`
  DROP `level`,
  DROP `priority`,
  DROP `office_id`,
  DROP `mwrlife_token`,
  DROP `payment_gateway`;"; 
  
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `payment_cards` ADD `shared_with_company_members` TINYINT(1) NOT NULL DEFAULT '0' AFTER `company_id`;"; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `payment_cards` ADD `expiration_date` DATE NULL DEFAULT NULL AFTER `last_four_digit`;"; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `payment_cards` ADD `nickname` VARCHAR(63) NULL DEFAULT NULL AFTER `shared_with_company_members`; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `payments_transactions` CHANGE `service_api_session_id` `checkout_session_id` VARCHAR(31) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL; "; 
		$this->db->query($sql);	
		
		$sql = "ALTER TABLE `users`
  DROP `office_id`,
  DROP `department_id`;"; 
		$this->db->query($sql);	
    }

    public function down()
    {
        //
    }
}
