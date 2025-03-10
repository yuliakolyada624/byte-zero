<?php

namespace App\ThirdParty;

use App\Modules\Hotels\Libraries\HotelsServices;

abstract class ServiceLouncher
{
	//private $module				= null;
	private $service_api_session_id = null;
	
	public function __construct($service_api_session_id) {
    	//$this->module = $module;
		$this->service_api_session_id = $service_api_session_id;
    }
	
	//abstract static function getServiceTempDataRows(); //by checkout_session_id
	abstract function getServiceTempDataRow(); //by service_session_id
	abstract function getServicePriceReviseData();
	abstract function serviceBooking($trips_stays_temp_data_row, $user);
	abstract function cancelServiceBooking();
	//abstract function updateServiceSpecialRequest($data);
	abstract function getNumberOfSimilarSuccessfulOrPendingBookings();
	
	static function getInstance($service_api_session_id, $module)
	{
		if($module == 'hotels')
		{
			return new HotelsServices($service_api_session_id);
		}
		else
			die('No module selected');
	}
	
	static function getServiceTempDataRows($checkout_session_id, $module) //by checkout_session_id
	{
		if($module == 'hotels')
		{
			return HotelsServices::getServiceTempDataRows($checkout_session_id, $module);
		}
		else
			die('No module selected');
	}

	function getServiceReviseIssues()
	{
		$error_type = null;
		
		$trips_stays_temp_data_row = $this->getServiceTempDataRow(); // todo - should we add here experation time ? 
		
		// if no record in DB = product is expired
		if(is_null($trips_stays_temp_data_row)) 
		{
			$error_type = 'product_expired';
			return $error_type;
		}	

		// price revise before booking
		$price_revise_result = $this->getServicePriceReviseData(); // Does a call to API to check actual product price

		if(empty($price_revise_result)) // api response didn't returned data due API call for price revision
		{
			$error_type = 'product_is_unavailable_by_api';
			return $error_type;
		}

		// new price is bigger than previous price
		if($price_revise_result['price_has_increased'])
		{ 
			$error_type = 'price_has_increased';
			return $error_type;
		}
		
	}
}