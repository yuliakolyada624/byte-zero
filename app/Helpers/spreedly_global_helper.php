<?php

/**
 * [authorizeGbl description]
 * @Created Date   2022-01-06T15:04:59+0530
 * @param   [type] $gatewayToken            [description]
 * @param   [type] $cardData                [description]
 * @return  [type]                          [description]
 */
function authorizeGbl($gatewayToken,$cardData)
{
	$payment_config = config('Payment');

	/*Getting the configurations*/
	$enviormentKey 	= $payment_config->enviorment_key;
	$secretKey		= $payment_config->secret_key;
	$gatewayToken 	= $payment_config->nmi_token;
	$scaProviderKey = $payment_config->sca_provider_key;

	/*If card type is amex then using USD amount*/
	if($cardData['gateway_name'] == 'NMI')
	{
		$cardData['amount'] 		= ceil($cardData['amountUSD']);
		$cardData['currency_code'] 	= "USD";
	}
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/gateways/$gatewayToken/authorize.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '{
	  "transaction": {
	    "payment_method_token": "'.$cardData['payment_method_token'].'",
	    "sca_provider_key": "'.$scaProviderKey.'",
	    "currency_code": "'.$cardData['currency_code'].'",
	    "amount": '.$cardData['amount'].',
	    "redirect_url": "'.$cardData['callback_url'].'",
	    "callback_url": "'.$cardData['callback_url'].'",
	    "browser_info": "'.$cardData['browser_info'].'"
	  }
	}');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($ch);
	curl_close ($ch);

	/*Admin Condition*/
	if(isset($cardData['isAdmin']) && $cardData['isAdmin'] == 1)
	{
		paymentApiLogJson($response,'manually_3ds2authorizedGbl_'.$cardData['log_id']);
	}
	else
	{
		paymentApiLogJson($response,'authorizedGbl'.$cardData['log_id']);
	}

	$result = json_decode($response);
	return $result;
}


/**
 * [purchaseGbl description]
 * @Created Date   2021-12-30T18:33:20+0530
 * @param   [type] $gatewayToken            [description]
 * @param   [type] $cardData                [description]
 * @return  [type]                          [description]
 */
function purchaseGbl($gatewayToken,$cardData)
{
	$payment_config = config('Payment');

	/*Getting the configurations*/
	$enviormentKey 	= $payment_config->enviorment_key;
	$secretKey		= $payment_config->secret_key;
	$gatewayToken 	= $payment_config->nmi_token;
	$scaProviderKey = $payment_config->sca_provider_key;
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/gateways/$gatewayToken/purchase.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '{
	  "transaction": {
	    "payment_method_token": "'.$cardData['payment_method_token'].'",
	    "sca_provider_key": "'.$scaProviderKey.'",
	    "currency_code": "'.$cardData['currency_code'].'",
	    "amount": '.$cardData['amount'].',
	    "redirect_url": "'.$cardData['callback_url'].'",
	    "callback_url": "'.$cardData['callback_url'].'",
	    "browser_info": "'.$cardData['browser_info'].'"
	  }
	}');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($ch);
	curl_close ($ch);

	/*Admin Condition*/
	if(isset($cardData['isAdmin']) && $cardData['isAdmin'] == 1)
	{
		paymentApiLogJson($response,'manually_3ds2authorized_'.$cardData['log_id']);
	}
	else
	{
		paymentApiLogJson($response,'purchaseGbl'.$cardData['log_id']);
	}

	$result = json_decode($response);
	return $result;
}