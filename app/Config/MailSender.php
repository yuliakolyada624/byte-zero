<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

class MailSender extends BaseConfig
{
	public string $mode				= 'dev'; //  dev || prod
    public string $from_email		= 'support@med-test.ai';
    public string $from_name		= 'Med-Test.ai';
    public string $testmode_email	= 'olexandr@med-test.ai';

}
