<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

class Payment extends BaseConfig
{



/*Payment Logs path*/
public $payment_log_path 		= WRITEPATH.'payment_logs/';

/*Test Credentails*/
//Spreedly tokens
public $enviorment_key 			= 'ApZAhBRpTIeQvXsZxuvOohEZu7A';
public $secret_key 				= 'Ra1y4gtqMilv0oqDso19MBDmjXPXoM7J7F6d8ffmyoK0uqCEEtexu4YKweYvNfNj';
public $sca_provider_key 		= '3wIlg76k00VYZI3bZErKjprpWq3';

//Gateway tokens
public $checkout_v2_token 		= '6MTzdW9t2v6K8E6GfdxdTRnKg8d';
public $nmi_token 				= '6MTzdW9t2v6K8E6GfdxdTRnKg8d';

public $payment_mode 			= 'Test';

/*Payment Gateway Status*/
public $is_spreedlyGlbl 		= false;
public $is_NMI 					= true;
public $is_checkoutV2 			= true;
	
	/**
	 *  Fetch some config from payment_activation file
	 */
	public function __construct()
	{
		parent::__construct();

		if (!file_exists($this->payment_log_path)) 
		{
            mkdir($this->payment_log_path, 0777);
		}


		$paymentJsonFile       = WRITEPATH.'json/payment_activation.json';
			
		if (file_exists($paymentJsonFile)) 
		{
			$paymentFileData       = file_get_contents($paymentJsonFile);
			$paymentFileData       = json_decode($paymentFileData, true);

			/*Payment Gateway Status*/
			$this->is_spreedlyGlbl 			= $paymentFileData['spreedlyGlbl']['NMI']['gateway_status'];
			$this->is_NMI 					= true;
			$this->is_checkoutV2 			= $paymentFileData['spreedly3ds']['Checkout']['gateway_status'];
		}

	}


	
}
