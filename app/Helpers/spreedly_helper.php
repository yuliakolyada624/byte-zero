<?php


/**
 * Description:
 * @CreatedDate:2019-11-06T19:32:57+0530
 */
function paymentApiLogJson($query,$name)
{
	$payment_config = config('Payment');
	$path = $payment_config->payment_log_path;
    file_put_contents($path.$name.'.json', $query);
}


/**
 * [getPaymentGatewayNon3ds description]
 * @updated by: Alex Kerest
 * @Created Date   2022-04-07T18:46:54+0530
 * @return  [type] [description]
 */
function getPaymentGatewayNon3ds($data)
{
	$payment_config = config('Payment');

	/*$customerData[0] = User Country
	$customerData[1] = Card Country
	$customerData[2] = From Admin
	$customerData[3] = CurrencyCode*/

	if ($data[0] == 'US' || $data[1] == 'US') {
		$countryFrom = 'US';
	} else {
		$countryFrom = 'Non-US';
	}

	if ($payment_config->is_spreedlyGlbl == true && $countryFrom == 'US') { /*When Spreedly glbl is on and from US*/
		$gatewayData['is_gateway_avlbl'] = true;
		$gatewayData['gateway_name'] = 'NMI';
		$gatewayData['spreedly_token'] = $payment_config->nmi_token;

		return (object) $gatewayData;
	} elseif ($payment_config->is_spreedlyGlbl == true && $payment_config->is_checkoutV2 == false) { /*When Only Spreedly gbl is on and non US users.*/
		$gatewayData['is_gateway_avlbl'] = true;
		$gatewayData['gateway_name'] = 'NMI';
		$gatewayData['spreedly_token'] = $payment_config->nmi_token;

		return (object) $gatewayData;
	} elseif ($payment_config->is_checkoutV2 == true) { /*For Non US customers and when only checkout is on*/
		$gatewayData['is_gateway_avlbl'] = true;
		$gatewayData['gateway_name'] = 'Checkout';
		$gatewayData['spreedly_token'] = $payment_config->checkout_v2_token;

		return (object) $gatewayData;
	} else { /*For Error handling*/
		$gatewayData['is_gateway_avlbl'] = false;
		return (object) $gatewayData;
	}
}



/**
 * Description:
 * @CreatedDate:2019-05-04T13:27:10+0530
 */
function getPaymentGateway($customerData,$cardType='',$payPrice=1)
{
    /*$customerData[0] = User Country
    $customerData[1] = Card Country
    $customerData[2] = From Admin
    $customerData[3] = CurrencyCode*/

    if($customerData[0] == 'US' || $customerData[1] == 'US')
    {
        $countryFrom = 'US';
    }
    else
    {
        $countryFrom = 'Non-US';
    }

    $isRandomGateway    = false;
    
    /*Gateway Selection*/
    return getSelectedGateway($countryFrom,$cardType,$payPrice,$isRandomGateway);
    
}

/**
 * [getSelectedGateway description]
 * @Created Date   2021-12-30T17:10:32+0530
 * @param   [type] $countryFrom             [description]
 * @param   [type] $cardType                [description]
 * @param   [type] $payPrice                [description]
 * @param   [type] $isRandomGateway         [description]
 * @return  [type]                          [description]
 */
function getSelectedGateway($countryFrom,$cardType,$payPrice,$isRandomGateway)
{
    $payment_config = config('Payment');

    if($payment_config->is_spreedlyGlbl == true && ($cardType == "american_express" || $countryFrom == "US") && $payPrice <= 300000)
    {/*When Spreedly glbl is on and card type is amex and from US*/
        $gatewayData['is_gateway_avlbl']    = true;
        $gatewayData['is_spreedlyGlbl']     = true;
        $gatewayData['gateway_name']        = 'NMI';
        $gatewayData['spreedly_token']      = $payment_config->nmi_token;
    }
    elseif($payment_config->is_spreedlyGlbl == true && $payment_config->is_checkoutV2 == false && $payPrice <= 300000)
    {/*When Only Spreedly gbl is on and non US and other card type users.*/
        $gatewayData['is_gateway_avlbl']    = true;
        $gatewayData['is_spreedlyGlbl']     = true;
        $gatewayData['gateway_name']        = 'NMI';
        $gatewayData['spreedly_token']      = $payment_config->nmi_token;
    }
    elseif($payment_config->is_checkoutV2 == true)
    {/*For Non US customers and when only checkout is on*/
        $gatewayData['is_gateway_avlbl']    = true;
        $gatewayData['is_spreedlyGlbl']     = false;
        $gatewayData['gateway_name']        = 'Checkout';
        $gatewayData['spreedly_token']      = $payment_config->checkout_v2_token;
    }
    else
    {/*For Error handling*/
        $gatewayData['is_gateway_avlbl']    = false;
        $gatewayData['is_spreedlyGlbl']     = false;
        $gatewayData['gateway_name']        = 'Checkout';
        $gatewayData['spreedly_token']      = $payment_config->checkout_v2_token; 
    }

    return (object)$gatewayData;
}



/** 
 * Description : get all card stored on spreedly
 * @update_by: Alex Kerest
 */
function getCardDetails($cardToken)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;

	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/payment_methods/$cardToken.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);
	$result = json_decode($response);

	return $result;
}


	/** 
	 * Description : save user card
	*/ 
	function saveCard($cardData, $randNum = null){
		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/payment_methods.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{"payment_method": {"credit_card": {"first_name":"'.$cardData['first_name'].'","last_name":"'.$cardData['last_name'].'","number": "'.$cardData['card_number'].'","verification_value":"'.$cardData['cvv_code'].'","month":"'.$cardData['month'].'","year":"'.$cardData['year'].'","address1":"'.$cardData['address'].'","zip":"'.$cardData['zip'].'","country":"'.$cardData['country'].'" },"email":"'.$cardData['email'].'","retained":"true"}}');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);

		curl_close ($ch);

		paymentApiLogJson($response,'create_'.$randNum);

		$result = json_decode($response);
		return $result;
	}


/**
	 * Description: verify card
	 * @Created Date   2018-08-13T13:31:09+0530
	 * @return  [type] [description]
	 */
	function verifyCard($gatewayToken,$cardToken,$randNum){

		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;

		$ch = curl_init();		
		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/gateways/".$gatewayToken."/verify.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{
		  "transaction": {
		    "payment_method_token":"'.$cardToken.'",
		    "retain_on_success": true
		  }
		}');
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		
		curl_close ($ch);

		paymentApiLogJson($response,'verify_'.$randNum);

		$result = json_decode($response);
		return $result;
	}


/* -------------------------------------------------------NOT testd!!!!-------------------------------------------------------------------------- */


/**
 * [authorizePayment description]
 * @Created Date   2021-12-31T16:35:10+0530
 * @param   [type] $gateWayData             [description]
 * @param   [type] $cardData                [description]
 * @return  [type]                          [description]
 */
function authorizePayment($gateWayData, $cardData)
{
    helper(array("spreedly3ds2", "spreedly_global"));

    if($gateWayData->is_spreedlyGlbl == true)
    {
        $authorize      = authorizeGbl($gateWayData->spreedly_token,$cardData);
    }
    else
    {
        $authorize      = authorizeCardv2($gateWayData->spreedly_token,$cardData);
    }

    return $authorize;
}
	/** 
	 * Description : Get token of paymentgateway
	 * Created Date: 11/05/2018 
	*/ 
	function createSpreedly($gateway_type){

		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/gateways.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{"gateway":{"gateway_type":"'.$gateway_type.'"}}');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey:$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		curl_close ($ch);

		$result = json_decode($response);
		if(array_key_exists("errors",$result)){
			$return_response = array("status" => 0,
							 	   "key" => $result->errors[0]->key); 
		}else{
			$return_response = array(
							"status" => 1,
							"record" => $result
							);
		}

		return $return_response;
	}

	/** 
	 * Description : charge card on spreedly
	 * Created Date: 14/05/2018 
	*/	
	function authorizeCard($gatewayToken,$cardData,$randNum = null, $isAdmin = 0){

		/*If card type is amex then using USD amount*/
		if($cardData['cardType'] == 'american_express' && $cardData['gateway_name'] == 'Checkout')
		{
			$amount 	= ceil($cardData['amountUSD']);
			$currency 	= 'USD';
		}
		else
		{
			$amount 	= $cardData['amount'];
			$currency 	= $cardData['currency_code'];
		}

		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/gateways/$gatewayToken/authorize.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{
		  "transaction": {
		    "payment_method_token": "'.$cardData['payment_method_token'].'",
		    "amount": '.$amount.',
		    "currency_code": "'.$currency.'"
		  }
		}');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		curl_close ($ch);

		/*Check Admin condition*/
		if($isAdmin == 1)
		{
			paymentApiLogJson($response,'manually_authorized_'.$randNum);
		}
		else
		{
			paymentApiLogJson($response,'authorize_'.$randNum);
		}

		$result = json_decode($response);
		//echo "<pre>"; print_r($result); exit();
		return $result;
	}

	/** 
	 * Description : refund amount 
	 * Created Date: 15/05/2018 
	*/
	function refund($transactionToken,$refundData){
		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$transactionToken/credit.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{
		  "transaction": {
		    "amount": '.$refundData['amount'].',
		    "currency_code": "'.$refundData['currency_code'].'"
		  }
		}');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);

		curl_close ($ch);

		$result = json_decode($response);

		return $result;
	}


	/** 
	 * Description : capture card for charge, this function will called after authorize card
	 * Created Date: 04/06/2018 
	*/
	function captureCard($transactionToken,$randNum = null, $isAdmin = 0){
		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$transactionToken/capture.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		curl_close ($ch);
		
		/*Check Admin condition*/
		if($isAdmin == 1)
		{
			paymentApiLogJson($response,'manually_captured_'.$randNum);
		}
		else
		{
			paymentApiLogJson($response,'capture_'.$randNum);
		}
		
		$result = json_decode($response);


		return $result;
	}

	/** 
	 * Description : delete card of customer
	 * Created Date: 22/06/2018 
	*/

	function deleteCard($token){
		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/payment_methods/$token/redact.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_PUT, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		curl_close ($ch);

		$result = json_decode($response);

		$cardData=array();

		if(isset($result->transaction) && $result->transaction->succeeded){

			$cardData['success'] = "true";
			$cardData['message'] = lang('Checkout.card_delete_msg');
		}
		elseif(isset($result->errors[0]->message)){

			$cardData['success'] = "false";	
			$cardData['errors']  =$result->errors[0]->message;
		}
		else{

			$cardData['success'] = "false";
			$cardData['errors']  = "Error while deleting card.";
		}

		return $cardData;
	}

	

	/**
	 * Description: Void Transaction
	 * @Created Date   2018-08-14T13:31:09+0530
	 * @return  [type] [description]
	 */
	function voidTransaction($transactionToken,$randNum = null){

		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/".$transactionToken."/void.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
		curl_setopt($ch, CURLOPT_POST, 1);
		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$response = curl_exec($ch);
		curl_close ($ch);
		
		paymentApiLogJson($response,'void_'.$randNum);

		$result = json_decode($response);
		return $result;
	}

	/** 
	 * Description : full refund
	 * Created Date: 23/08/2018 
	*/
	function fullRefund($transactionToken){
		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$transactionToken/credit.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);

		curl_close ($ch);

		$result = json_decode($response);

		return $result;
	}

	/**
	 * [updateCreditCard description]
	 * @Created Date   2021-04-27T16:39:30+0530
	 * @param   [type] $cardData                [description]
	 * @param   [type] $cardToken               [description]
	 * @return  [type]                          [description] ,"month": "'.$cardData['month'].'","year": "'.$cardData['year'].'"
	 */
	function updateCard($cardData, $cardToken)
	{
		$payment_config = config('Payment');
		$enviormentKey = $payment_config->enviorment_key;
		$secretKey = $payment_config->secret_key;
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/payment_methods/$cardToken.json");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, '{"payment_method": {"first_name": "'.$cardData['first_name'].'","last_name": "'.$cardData['last_name'].'","address1":"'.$cardData['address'].'","month":"'.$cardData['month'].'","year":"'.$cardData['year'].'","country":"'.$cardData['country'].'","zip":"'.$cardData['zip'].'"}}');
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey:$secretKey");

		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);

		curl_close($ch);

		paymentApiLogJson($response,'update_'.$cardToken.'_'.date('YmdHis'));

		$result = json_decode($response);
		return $result;
	}

?>