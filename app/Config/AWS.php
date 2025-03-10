<?php

/* Config/AWS.php */

namespace Config;

use CodeIgniter\Config\BaseConfig;

class AWS extends BaseConfig
{

public $region = 'us-east-1';

public $accessKey = '';
public $secretKey = '';

public $inputS3bucket = '';
public $outputS3bucket = '';

}