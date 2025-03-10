<?php 

namespace App\Libraries;

require_once(__DIR__ . './../../vendor/autoload.php');

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalSMSApi;
use Brevo\Client\Model\SendTransacSms;
use GuzzleHttp\Client;


class SMSSender
{
    protected $apiKey;
    protected $sender;

    public function __construct()
    {
        // Load settings from the .env file
        $this->apiKey = getenv('brevo_api_key');
        $this->sender = getenv('brevo_sms_sender');
    }

    /**
     * Send SMS
     * 
     * @param string $recipient Phone number of the recipient
     * @param string $content Message content
     * @param string $webUrl Optional webhook URL for delivery status updates
     * @return mixed Response from the API or false if failed
     */
    public function sendSms(string $recipient, string $content, string $webUrl = null)
    {
        // Configure API with the API key
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->apiKey);

        // Create API instance
        $apiInstance = new TransactionalSMSApi(new Client(), $config);

        // Create SMS model
        $sendTransacSms = new SendTransacSms();
        $sendTransacSms['sender'] = $this->sender;
        $sendTransacSms['recipient'] = $recipient;
        $sendTransacSms['content'] = $content;
        $sendTransacSms['type'] = 'transactional';

        // Optional webhook URL for status updates
        if ($webUrl) {
            $sendTransacSms['webUrl'] = $webUrl;
        }

        try {
            // Send the SMS
            return $apiInstance->sendTransacSms($sendTransacSms);
        } catch (\Exception $e) {
            // Log the exception and return false on failure
            log_message('error', 'Exception when sending SMS: ' . $e->getMessage());
            return false;
        }
    }


    public function send2FASMS($phone_number, $code)
    {
        return $this->sendSms($phone_number, "Your Temporary Med-Test Confirmation Code Is: $code");
    }
}