<?php

namespace App\Libraries;

use CodeIgniter\Config\Services;
use Psr\Log\LoggerInterface;
use CodeIgniter\View\View as BaseView;

class View extends BaseView
{

    
    /**
     * @var string
     */
    protected $viewPrefix;

    /**
     * @var \CodeIgniter\HTTP\IncomingRequest
     */
    public $request;

   
    
     /**
     * View constructor.
     * @param $config
     * @param string|null $viewPath
     * @param null $loader
     * @param bool|null $debug
     * @param LoggerInterface|null $logger
     */
    public function __construct($config = null, string $viewPath = null, $loader = null, bool $debug = null, LoggerInterface $logger = null)
    {
    //dd('VVV');
        $config == null && $config = new \Config\View();
        $app_config = config('App');
        parent::__construct($config, $viewPath, $loader, $debug, $logger);
        $this->request = Services::request();
        $this->viewPrefix = $app_config->theme;
    }
    
    
     /**
     * Reset the config file
     *
     * @param $config
     */
    public function setConfig($config)
    {
        $this->config = $config;
        $app_config = config('App');
        $this->viewPrefix = $app_config->theme;
    }

    /**
     * Add path to the view file
     *
     * @param string $view
     * @param array|null $options
     * @param bool|null $saveData
     * @return string
     */
    public function render(string $view, array $options = null, bool $saveData = null): string
    {
        // exeptions for system /shield templates
        if(!strstr($view, 'default') && !strstr($view, 'CodeIgniter') ){
            $defView = 'default/'.$view;    
        } else {
            $defView = $view;
        }
        $view = $this->viewPrefix . "/" . $view;
        
        if (!is_file(APPPATH . 'Views/'.$view.'.php')) {
            $view = $defView;
        }
        return parent::render($view, $options, $saveData);
    }
}
