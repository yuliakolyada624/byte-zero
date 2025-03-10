<?php

/*
    Logs a payment API query as a JSON file.
    @param string $query The JSON-encoded payment API query to log.
    @param string $name The name to give to the log file.
    @return void
  */
if(! function_exists('paymentApiLogJson')){
	function paymentApiLogJson($query,$name)
	{
		$payment_config = config('Payment');
		$path = $payment_config->payment_log_path;
		file_put_contents($path.$name.'.json', $query);
	}
}



/*
    Inserts transaction data into the database using the PaymentsTransactionsModel.
    @param array $data An array of data to be inserted into the database.
    @return bool True if the insertion was successful, false otherwise.
*/
function insertTransactionData($data){
    $PaymentsTransactionsModel = new App\Modules\Checkout\Models\PaymentsTransactionsModel();
	
	$records_count = $PaymentsTransactionsModel->where('checkout_session_id', $data['checkout_session_id'])->where('authorization_transaction_token', $data['authorization_transaction_token'])->countAllResults();
	
	if(!$records_count) // to avoid duplicates records while testing
	{	
		$PaymentsTransactionsModel->insert($data);	
		$paymentTransactionId = $PaymentsTransactionsModel->getInsertID();
		
		if($paymentTransactionId)
		{
			$CurrenciesModel = new App\Modules\Currencies\Models\CurrenciesModel();
			$rows = $CurrenciesModel->asObject()->select('code, rate')->findAll();
			
			$currencyRatesSnapshot = new \stdClass();
			$currencyRatesSnapshot->transaction_id = $paymentTransactionId;
			
			foreach($rows as $row)
			{
				$currencyCode = $row->code;
				$currencyRatesSnapshot->$currencyCode = $row->rate;
			}
			
			$PaymentsTransactionsCurrencyRatesModel = new App\Modules\Checkout\Models\PaymentsTransactionsCurrencyRatesModel();
			$PaymentsTransactionsCurrencyRatesModel->insert($currencyRatesSnapshot);			
		}
	}
}

/* function currencyRates()
{
	$CurrenciesModel = new App\Modules\Currencies\Models\CurrenciesModel();
	$rows = $CurrenciesModel->asObject()->select('code, rate')->findAll();
	
	$currencyRatesSnapshot = new \stdClass();
	foreach($rows as $row)
	{
		$currencyCode = $row->code;
		$currencyRatesSnapshot->$currencyCode = $row->rate;
	}
	
	print_r($currencyRatesSnapshot); die;
} */


/*
    Retrieves transaction data from the database using the PaymentsTransactionsModel.
    @param string $service_api_session_id The order session ID to retrieve transaction data for.
    @return mixed An object representing the first transaction record with the specified order session ID, or null if no record is found.
    */
function getTransactionData($checkout_session_id){
	$PaymentsTransactionsModel = new App\Modules\Checkout\Models\PaymentsTransactionsModel();
	$results 	= $PaymentsTransactionsModel->where('checkout_session_id', $checkout_session_id)->first();
	//$PaymentsTransactionsModel->update($id, []);
	return $results;
}


/*

    Updates the payment transaction data for a given transaction ID.
    @param int $id The ID of the transaction to update.
    @param array $data An associative array containing the data to update.
*/
function updateTransactionData($id, $data){
	$PaymentsTransactionsModel = new App\Modules\Checkout\Models\PaymentsTransactionsModel();
	$results = $PaymentsTransactionsModel->update($id, $data);
	return $results;
}



/**
 * Description:
 * @CreatedDate:2019-11-06T12:22:47+0530
 */
function voidTransactionv2($transactionToken,$logId)
{
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
	curl_close($ch);

	paymentApiLogJson($response,'void_'.$logId);

	$result = json_decode($response);
	return $result;
}

/**
 * Description:
 * @CreatedDate:2019-11-05T17:16:09+0530
 */
function authorizeCardv2($gatewayToken,$cardData)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;
	
	/*If card type is amex then using USD amount*/
	if($cardData['cardType'] == 'american_express' && $cardData['gateway_name'] == 'Checkout')
	{
		$amount 		= ceil($cardData['amountUSD']);
		$currency 	= 'USD';
	}
	else
	{
		$amount 	= $cardData['amount'];
		$currency 	= $cardData['currency_code'];
	}

	/*Creating Request para*/
	$requestPara = '{
	  "transaction": {
	    "payment_method_token": "'.$cardData['payment_method_token'].'",
	    "amount": '.$amount.',
	    "currency_code": "'.$currency.'",
	    "redirect_url": "'.$cardData['redirect_url'].'",
	    "callback_url": "'.$cardData['callback_url'].'",
	    "three_ds_version": "2",
	    "attempt_3dsecure": true,
	    "browser_info": "'.$cardData['browser_info'].'"';

	    /*Adding gateway specific field only in checkout gateway case*/
		if($cardData['amountUSD'] < 60000 && $cardData['gateway_name'] == 'Checkout')
	    {
	    	$requestPara .= ',"gateway_specific_fields" : {
		    	"checkout_v2" : {
		    		"attempt_n3d": true
		    	}}';
	    } 
	  	
	$requestPara .= '}}';
	
	echo $requestPara; die;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/gateways/$gatewayToken/authorize.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $requestPara);
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
		paymentApiLogJson($response,'authorize_'.$cardData['log_id']);
	}

	$result = json_decode($response);
	return $result;
}

/**
 * Description:
 * @CreatedDate:2019-11-06T12:16:22+0530
 */
function captureCardv2($transactionToken,$logId, $isAdmin = 0)
{
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
		paymentApiLogJson($response,'manually_3ds2captured_'.$logId);
	}
	else
	{
		paymentApiLogJson($response,'capture_'.$logId);
	}

	$result = json_decode($response);

	return $result;
}

/**
 * Description:
 * @author: Nikolay Sokolov
 * @CreatedDate:2019-11-06T12:16:22+0530
 */
function captureCardPartial2($transactionToken,$logId,$cardData = false)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$transactionToken/capture.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
    
    if($cardData)
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "transaction": {
            "amount": '.$cardData['amount'].',
            "currency_code": "'.$cardData['currency_code'].'"
          }
        }');
    }

	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close ($ch);
	
	paymentApiLogJson($response,'capture_'.$logId);

	$result = json_decode($response);

	return $result;
}


/**
 * Description:
 * @CreatedDate:2019-11-06T15:41:03+0530
 */
function completeTransactionv2($purchaseToken)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$purchaseToken/complete.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);

	//paymentApiLogJson($response,'complete_'.$purchaseToken);

	$result = json_decode($response);
	return $result;
}

/**
 * Description:
 * @CreatedDate:2019-11-08T13:05:54+0530
 */
function finalizePurchase($transactionToken,$logId, $isAdmin = 0)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$transactionToken.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);

	/*Check Admin condition*/
	if($isAdmin == 1)
	{
		paymentApiLogJson($response,'manually_3ds2finalize_'.$logId);
	}
	else
	{
		paymentApiLogJson($response,'finalize_purchase_'.$logId);
	}

	$result = json_decode($response);
	return $result;
}

/**
 * Description:
 * @CreatedDate:2019-12-06T15:40:05+0530
 */
function getCardDetailsv2($cardToken)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;
	
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, "https://core.spreedly.com/v1/payment_methods/$cardToken.json");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");
	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($curl);
	curl_close ($curl);
	
	$result = json_decode($response);
	return $result;
}

/**
 * [partialCaptureCardv2 Partially Capture payment]
 * @Created Date   2019-12-10T18:55:53+0530
 * @param   [type] $transactionToken        [description]
 * @param   [type] $logId                   [description]
 * @return  [type]                          [description]
 */
function partialCaptureCardv2($transactionToken,$logId,$cardData)
{
	$payment_config = config('Payment');
	$enviormentKey = $payment_config->enviorment_key;
	$secretKey = $payment_config->secret_key;
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, "https://core.spreedly.com/v1/transactions/$transactionToken/capture.json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, '{
	  "transaction": {
	    "amount": '.$cardData['amount'].',
	    "currency_code": "'.$cardData['currency_code'].'"
	  }
	}');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_USERPWD, "$enviormentKey" . ":" . "$secretKey");

	$headers = array();
	$headers[] = "Content-Type: application/json";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close ($ch);
	
	paymentApiLogJson($response,'partialCapture_'.$logId);

	$result = json_decode($response);

	return $result;
}
