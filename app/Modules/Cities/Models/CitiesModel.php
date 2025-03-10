<?php namespace App\Modules\Cities\Models;

use App\Libraries\Filters;
use CodeIgniter\Model;

class CitiesModel extends Model
{
    protected $table  = 'cities';
    protected $allowedFields  = [
        'geonameid',
        'name',
        'ascii_name',
        'alternate_names',
        'feature_class',
        'feature_code',
        'country_code',
        'country_name',
        'country_code2',
        'population',
        'elevation',
        'digital_elevation_model',
        'timezone',
        'label_en',
        'coordinates',
        'active'
    ];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

    protected $returnType     = CitiesModel::class;


    

    private function _set_condition(){
        $filters = new Filters();
        $filters_data = $filters->get_filters('cities');
        //dd($filters_data);
        
        if(isset($filters_data['search']) and $filters_data['search'])
        {
            $search_lower = addslashes(mb_strtolower(trim($filters_data['search'])));
           
            $this->builder()->where("(".
                "(LOWER({$this->table}.name) LIKE '{$search_lower}%') ".
                "OR (LOWER({$this->table}.country_code) LIKE '{$search_lower}') ".
                "OR (LOWER({$this->table}.country_name) LIKE '{$search_lower}') ".
                "OR (LOWER({$this->table}.timezone) LIKE '{$search_lower}') ".
                "OR (LOWER({$this->table}.label_en) LIKE '{$search_lower}') ".
                ")");   
        }

        if (isset($filters_data['status']) && $filters_data['status']!='' ) {
            $this->builder()->where("{$this->table}.active", $filters_data['status']);
        }

        if (isset($filters_data['population']) && $filters_data['population']!='' ) {
            $this->builder()->where("{$this->table}.population>".$filters_data['population']);
        }

    }


    public function getCitiesList()
    {
        $this->_set_condition();

        $this->builder()->select("{$this->table}.*");
                        
        return $this;
    }


}
