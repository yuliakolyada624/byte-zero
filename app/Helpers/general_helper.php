<?php

declare(strict_types=1);


if (! function_exists('random_password')) {
    function random_password($length=8)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_+=-<>?/,.';
        $password = str_shuffle($alphabet);
        return substr($password, 0, $length);
    }
}

if (! function_exists('price_format')) {
    /* show all prices in one format  */
    function price_format($price, $decimals = 0)
    {
        return number_format((float)$price, $decimals);
    }
}


if (! function_exists('LogAndNotify')) {
    function LogAndNotify($message, $status='info'){
        // TODO make log

		$NotificationsConfig = config('LogsAndNotifications');

		$NotificationChanels = explode(',', $NotificationsConfig->NotificationChanels);
		$NotificationChanels = array_map('trim', $NotificationChanels);

		$TelegramChatIds = explode(',', $NotificationsConfig->TelegramChatIds);
		$TelegramChatIds = array_map('trim', $TelegramChatIds);

		if(in_array('slack', $NotificationChanels)){
			slack("*$status:* $message");
		}

		if(in_array('telegram', $NotificationChanels)){
			foreach($TelegramChatIds as $chat_id)
			{
				telegram($message, $NotificationsConfig->TelegramApiToken, $chat_id, $status);
			}
		}
    }
}



/**
 * Send a Message to a Slack Channel.
 *
 * In order to get the API Token visit: 
 *
 * 1.) Create an APP -> https://api.slack.com/apps/
 * 2.) See menu entry "Install App"
 * 3.) Use the "Bot User OAuth Token"
 *
 * The token will look something like this `xoxb-2100000415-0000000000-0000000000-ab1ab1`.
 * 
 * @param string $message The message to post into a channel.
 * @param string $channel The name of the channel prefixed with #, example #foobar
 * @return boolean
 */
function slack($message, $channel='ua-team')
{
    //curl -X POST -H 'Content-type: application/json' --data '{"text": "'"${RESP}"'"}' 

    $ch = curl_init("https://hooks.slack.com/services/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");
  
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    $payload = json_encode( array( "text"=> $message ) );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    //var_dump($result);
    curl_close($ch);
    
    return $result;
}

/* Sends a telegram message to one contact */
function telegram($message, $apiToken = null, $chat_id = null, $status = 'info')
{	
	$icon = '';
	if(strtolower($status) == 'error')
		$icon = "\xF0\x9F\x9A\xA8 ";

	if($apiToken and $chat_id) {
		$data = [
			'chat_id' => $chat_id, // TODO to config
			'text' => "$icon*$status:* $message",
			'parse_mode' => 'Markdown'
		];
		$postdata = http_build_query($data);

		$opts = array(
			'http' =>
			array(
				'method' => 'POST',
				'header' => 'Content-type: application/x-www-form-urlencoded',
				'content' => $postdata
			)
		);

		$url = "https://api.telegram.org/bot{$apiToken}/sendMessage?";
		$context = stream_context_create($opts);
		$res = file_get_contents($url, false, $context);
	}
}



if (! function_exists('get_currency')) {
    
    function get_currency()
    {
        helper('cookie');
		
		$currency = "USD";
		
        $cookie_currency = get_cookie('currency');
        // exist set in cookie
        if($cookie_currency){
            $currency = $cookie_currency;
        }
        // check user data
        $user = auth()->user();
		if ($user) {            
			if(!is_null($user->currency))
			{
				$currency = $user->currency;				
			}
        }
        //return default
        return $currency;
    }
}

if (! function_exists('get_currency_row')) {
	
	function get_currency_row($currency_code, $available_methods_array = null)
    {

		$currenciesModel = new \App\Modules\Currencies\Models\CurrenciesModel();
		$currency_row = $currenciesModel->GetCurrencyRowByCurrencyCode($currency_code);
		
		if(is_array($available_methods_array))
		{
			$methods_array = array_intersect_key(get_object_vars($currency_row), array_flip($available_methods_array));
			$filtered_currency_row = new \stdClass;
			foreach($methods_array as $available_method_key => $available_method_value)
			{
				$filtered_currency_row->$available_method_key = 
				$currency_row->$available_method_key;
			}
			$currency_row = $filtered_currency_row;
		}
		
		return $currency_row;		
	}
	
}

if (! function_exists('CurrencyConvertion')) {
	
	function CurrencyConvertion($amount, $currency_code_from, $currency_code_to)
	{
		$currenciesModel = new \App\Modules\Currencies\Models\CurrenciesModel();
		$CurrencyRatesArray = $currenciesModel->GetCurrencyRatesByCurrencyCodes([$currency_code_from, $currency_code_to]);
		$convertedAmount = $amount/$CurrencyRatesArray[$currency_code_from]*$CurrencyRatesArray[$currency_code_to];
		return round($convertedAmount,2);
	}

}

if (! function_exists('get_language')) {
    
    function get_language()
    {
        // 1. url 2. cookie 3. user 4. default

        $current_url = current_url();
        $uri = new \CodeIgniter\HTTP\URI($current_url);
        $url_locale = $uri->getSegment(1);
        
        $supportedLocales = config('App')->supportedLocales;

        if(in_array($url_locale, $supportedLocales)){
            return $url_locale;
        }

        helper('cookie');

        $language = get_cookie('lang');
        // exist set in cookie
        if($language){
            return $language;
        }
        // check user data
        $user = auth()->user();
		if ($user) {            
			if(isset($user->language) and !is_null($user->language)){
                return $user->language;
            }
        }
        //return default
        return config('App')->defaultLocale;
    }
}

if (! function_exists('getHrefLanguages')) {
    
    function getHrefLanguages()
    {
        $current_url = current_url();
       // d($current_url);
        $uri = new \CodeIgniter\HTTP\URI($current_url);
        $url_locale = $uri->getSegment(1);
       // d($url_locale);

        $supportedLocales = (config('App')->supportedLocales);

        $locale = in_array($url_locale, $supportedLocales) ? $url_locale : config('App')->defaultLocale;

       // d($locale);

        $href_langs = [];
        foreach($supportedLocales as $sl){
            if($uri->getPath()=='/'){
                $href_langs[$sl] = '/'.$sl;
            } else {
                $href_langs[$sl] = str_replace($locale, $sl, $uri->getPath());
            }
        }

        // Fix prefix for en (/en to /)
        $href_langs['en'] = (strlen($href_langs['en'])==3 ? '/' : str_replace('/en', '', $href_langs['en']) );

       // d($href_langs);

        return $href_langs;
    }
}


if (! function_exists('url_to_lang')) {

    function url_to_lang(string $controller, ...$args): string
    {
        $url = url_to($controller, ...$args);
        //dd($url);
        $url = str_replace('/en', '', $url);
        return $url;
    }
}




if (! function_exists('user_avatar')) {
    function user_avatar(int $user_id, int $width=30, int $height=30): string
    {
        $url = "/user/profile-avatar/$user_id?width=$width&height=$height";
        return $url;
    }
}


if (! function_exists(function: 'format_date')) {

    function format_date($datetime, $type='full'): string
    {
        if(is_null($datetime)){
            return '';
        }
        // Retrieve the timezone from your configuration (e.g., app or custom config)
        $config = config('App'); // TODO from company settings!!!
        $Apptimezone = $config->appTimezone ?? 'UTC'; 

        $timezone = 'EST'; // Default to 'America/New_York' (EST) 
    
        try {
            // Create a DateTime object from the input datetime (assumed to be in UTC)
            $date = new DateTime($datetime, new DateTimeZone($Apptimezone));
    
            // Set the timezone based on the configuration or default to EST
            $date->setTimezone(new DateTimeZone($timezone));
            if($type=='full')
                return $date->format('d-m-Y H:i:s T');
            if($type=='date')
                return $date->format('d-m-Y');
            if($type=='time')
                return $date->format('H:i T');
        } catch (Exception $e) {
            // In case of an error (invalid date format), return the original datetime or an error message
            return $datetime; // Or return 'Invalid Date' for better error handling
        }
    }
    

}


function isActiveInjuryArea($area, $injuryAreas) {
    return in_array($area, $injuryAreas) ? 'active' : '';
}


function getInjuryDetailsList(){
    return [
        'head_and_neck' => [
            'title' => 'HEAD AND NECK',
            'components' => 'Skull, Face, Brain, Eyes, Nose, Mouth, Ears, Cheeks, Jaw, Cervical spine.',
            'musculoskeletal' => 'Bones (Skull, Cervical spine), Muscles, and Connective Tissues (Neck muscles, tendons, ligaments).',
        ],
        'upper_extremity' => [
            'title' => 'UPPER EXTREMITY (Right, Left, or BOTH)',
            'components' => 'Shoulder, Arm (Humerus, Radius, Ulna), Elbow, Forearm, Wrist, Hand (Carpals, Metacarpals, Phalanges, Fingers).',
            'musculoskeletal' => 'Bones (Clavicle, Scapula, Humerus, Radius, Ulna, Carpals, Metacarpals, Phalanges), Muscles, and Connective Tissues (Muscles, tendons, and ligaments of the upper limb).',
        ],
        'torso' => [
            'title' => 'TORSO',
            'components' => 'Thorax (Chest, Ribcage, Sternum), Abdomen (Stomach, Liver, Spleen, Pancreas, Kidneys, Intestines), Pelvis (Hips, Reproductive Organs), Diaphragm.',
            'musculoskeletal' => 'Bones (Ribcage, Sternum, Pelvis), Muscles, and Connective Tissues (Abdominal muscles, pelvic muscles, diaphragm).',
        ],
        'back' => [
            'title' => 'BACK',
            'components' => 'Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula.',
            'musculoskeletal' => 'Bones (Thoracic Spine, Lumbar Spine, Coccyx, Sacrum, Clavicle, Scapula), Muscles, and Connective Tissues (Muscles and ligaments supporting the back and spinal column).',
        ],
        'lower_extremity' => [
            'title' => 'LOWER EXTREMITY (Right, Left, or BOTH)',
            'components' => 'Hip, Thigh (Femur), Knee (Patella), Leg (Tibia, Fibula), Ankle, Foot (Tarsals, Metatarsals, Phalanges, Toes).',
            'musculoskeletal' => 'Bones (Femur, Patella, Tibia, Fibula, Tarsals, Metatarsals, Phalanges), Muscles, and Connective Tissues (Muscles, tendons, and ligaments of the lower limb).',
        ],
        'internal_organs' => [
            'title' => 'INTERNAL ORGANS',
            'components' => 'Heart, Lungs, Liver, Spleen, Pancreas, Kidneys, Bladder, Stomach, Intestines, Reproductive Organs.',
        ],
        'skin' => [
            'title' => 'SKIN',
            'description' => "The body's largest organ, covering and protecting all external surfaces.",
        ],
        'circulatory_and_nervous_systems' => [
            'title' => 'CIRCULATORY AND NERVOUS SYSTEMS',
            'components' => 'Blood Vessels and Nerves throughout the body.',
        ],
    ];
}