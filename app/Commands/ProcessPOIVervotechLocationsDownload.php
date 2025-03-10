<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ProcessPOIVervotechLocationsDownload extends BaseCommand
{
    protected $group       = 'Process';
    protected $name        = 'process:dvlscv';
    protected $description = 'Download Vervotech Locations CSV file';

    public function run(array $params)
    {
        $POI_Controller = new \App\Modules\POI\Controllers\POI;
        $benchmark = \Config\Services::timer();
        $benchmark->start('process');
        CLI::write('PHP Version: ' . CLI::color(PHP_VERSION, 'yellow'));        

        $POI_Controller->get_vervotech_csv();

        $benchmark->stop('process');
        $process_time =  timer()->getElapsedTime('process');
        CLI::write('Process time: ' . CLI::color($process_time, 'yellow'));
    }
}
