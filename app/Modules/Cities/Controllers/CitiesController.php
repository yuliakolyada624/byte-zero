<?php namespace App\Modules\Cities\Controllers;

use App\Modules\Cities\Models\CitiesModel;
use CodeIgniter\Controller;
use App\Libraries\Filters;

/*
DATA source https://public.opendatasoft.com/explore/dataset/geonames-all-cities-with-a-population-1000/table/?disjunctive.cou_name_en&sort=name
*/

class CitiesController extends Controller
{
    private $citiesModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->citiesModel = new CitiesModel();
    }

    public function index()
	{
        $cities = $this->citiesModel->getCitiesList()->paginate(20);
        //dd($this->citiesModel->db->getlastQuery());
        $filters = new Filters();
        $filters_data = $filters->get_filters('cities');

        $data = [ 'cities' => $cities, 
                  'pager'=>$this->citiesModel->pager, 
                  'filters_data'=>$filters_data,
                  'title' => 'Cities List'
                ];

		return view('Admin/Cities/list', $data);
	}



    public function edit($id){
        $City = $this->citiesModel->find($id);
        
        $data = [ 'city' => $City, 'title' => 'Edit City'];
        return view('Admin/Cities/edit', $data);
    }



    public function update(){
        $rules = [
            'name' => 'required|min_length[3]|max_length[20]'
            ];

        if (! $this->validate($rules)) {
            
            return redirect()->to('/cities/edit/'.$this->request->getPost('id'))->withInput()->with('errors', $this->validator);
        }else{
            $newData = [
                        'id' => $this->request->getPost('id'),
                        'geonameid' => $this->request->getPost('geonameid'),
                        'name' => $this->request->getPost('name'),
                        'ascii_name' => $this->request->getPost('ascii_name'),
                        'alternate_names' => $this->request->getPost('alternate_names'),
                        'feature_class' => $this->request->getPost('feature_class'),
                        'feature_code' => $this->request->getPost('feature_code'),
                        'country_code' => $this->request->getPost('country_code'),
                        'country_name' => $this->request->getPost('country_name'),
                        'country_code2' => $this->request->getPost('country_code2'),
                        'population' => $this->request->getPost('population'),
                        'elevation' => $this->request->getPost('elevation'),
                        'digital_elevation_model' => $this->request->getPost('digital_elevation_model'),
                        'timezone' => $this->request->getPost('timezone'),
                        'label_en' => $this->request->getPost('label_en'),
                        'coordinates' => $this->request->getPost('coordinates'),
                        'active' => $this->request->getPost('active')
                        ];
            
            $this->citiesModel->save($newData);

            session()->setFlashdata('success', 'Successfuly Updated');
            return redirect()->to('/cities/list');

        }
    }



    public function setFilters(){
        $filters = new Filters();
        $filters->set_filters('cities');

        return redirect()->to('/cities/list');
    }


    public function import()
    {
        
        $filePath = WRITEPATH . '/import/geonames-all-cities-with-a-population-1000.csv';
        $file = new \CodeIgniter\Files\File($filePath);
        d($file);

        if ($file->getExtension() === 'csv') {
          
            if (($handle = fopen($filePath, 'r')) !== false) {
                $header = fgetcsv($handle, null, ';'); // Read the header row

                while (($data = fgetcsv($handle,  null, ';')) !== false) {
                    // Process each row of data and insert into the database
                   
                  //  dd( $data);
                   

                    $dataToInsert = [
                        'geonameid' => $data[0],
                        'name' => $data[1],
                        'ascii_name' => $data[2],
                        'alternate_names' => $data[3],
                        'feature_class' => $data[4],
                        'feature_code' => $data[5],
                        'country_code' => $data[6],
                        'country_name' => $data[7],
                        'country_code2' => $data[8],
                        'population' => $data[13],
                        'elevation' => $data[14],
                        'digital_elevation_model' => $data[15],
                        'timezone' => $data[16],
                        'label_en' => $data[18],
                        'coordinates' => $data[19],
                    ];

                    //dd($dataToInsert);

                    
                    $this->citiesModel->insert($dataToInsert);
                }

                fclose($handle);
            }

            echo  'CSV file imported successfully.';
        } else {
            echo  'Invalid CSV file. Please upload a valid CSV file.';
        }
    }


    public function addPOITask($id)
    {
        $city = $this->citiesModel->find($id);  
        
        $tmp = explode(',', $city->coordinates);
        
        $lat = floatval($tmp[0]);
        $lng = floatval($tmp[1]);
        
        $scan_size = 1;
       
        if($city->population>1000000){ // over 1M = 5 point
          //  $scan_size = 5; // off for data4seo
        }
        //dd($city);
       
        $POI_Service = new \App\Modules\POI\Services\POIService;
        $resp = $POI_Service->addPOITask($lat, $lng, $city->name.', '.$city->country_name.'('.$city->country_code.') from cities', $scan_size);
        //dd($resp);
       if($resp===null){
        session()->setFlashdata('error', 'POI Task not saved - '.$POI_Service->getAdd_status());
       } else {
        session()->setFlashdata('success', 'POI Task Successfuly Added - '.$POI_Service->getAdd_status());
       }

        
        return redirect()->to('/cities/list');
    }
}
