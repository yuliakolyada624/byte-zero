<?php namespace App\Libraries;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;


class Filters extends Controller
{
    /* SET filter config fields as name - $_***_filter_fields, where *** - is $key */
    private $_bookings_filter_fields = [
                                        'search',
                                        'booking_status',
                                        'start',
                                        'end'
                                        ];
	private $_articles_filter_fields = [
                                        'search',
                                        'is_active',
                                        'category_id'
                                        ];									
										
    private $_cities_filter_fields = [
                                        'search',
                                        'status',
                                        'population'
                                        ];

    private $_POITasks_filter_fields = [
                                        'address',
                                        'search_type',
                                        'latitude',
                                        'longitude',
                                        'place_id',
                                    ];
    private $_POIControl_filter_fields   = [
                                    'address',
                                    'search_type',
                                    'latitude',
                                    'longitude',
                                    'place_id',
                                    'search',
                                    'business_status'
                                ];

    protected $request;
    protected $session;

    public function __construct(){
        
        $this->session = session();
        $this->request = \Config\Services::request();
    }


    /** 
    * Retrieve filters for a given key
    * @param string $key The key for which to retrieve filters
    * @return array An associative array of filters, with filter field names as keys and filter values as values
    */
    public function get_filters($key)
	{            
		$filters = array();
		
        $conf = '_'.$key.'_filter_fields';
        $fields = $this->$conf;
        foreach($fields as $field){
            $filters[$field] = $this->session->get('filter_'.$key.'_'.$field);
        }
        
		return $filters;
	}
    
    
    /**
    * Set filters for a given key and  reset filters 
    * @param string $key The key for which to set filters
    * @return void
    */
	public function set_filters($key)
	{
        $reset_filters = (int)$this->request->getPost('reset_filters');
        
        $conf = '_'.$key.'_filter_fields';
        $fields = $this->$conf;

		if($reset_filters)
        {   
            $to_unset = array();
            foreach($fields as $field){
                $to_unset[] = 'filter_'.$key.'_'.$field;
            }
            $this->session->remove($to_unset);
        }
		else
		{
            foreach($fields as $field){
                if($this->request->getPost($field)){
                    $this->session->set('filter_'.$key.'_'.$field, trim($this->request->getPost($field)));            
                }
            }
		}
	}
    
}