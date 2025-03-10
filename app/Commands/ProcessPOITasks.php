<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ProcessPOITasks extends BaseCommand
{
    protected $group       = 'Process';
    protected $name        = 'process:poi';
    protected $description = 'Process tasks for POI';

    public function run(array $params)
    {
        $POI_Service = new \App\Modules\POI\Services\POIService;
        $benchmark = \Config\Services::timer();
        $benchmark->start('process');
        CLI::write('PHP Version: ' . CLI::color(PHP_VERSION, 'yellow'));
        

        $POI_Service->processTasks();



        $benchmark->stop('process');
        $process_time =  timer()->getElapsedTime('process');
        CLI::write('Process time: ' . CLI::color($process_time, 'yellow'));
    }
}
