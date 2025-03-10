<?php namespace App\Modules\Countries\Controllers;

use App\Modules\Countries\Models\CountriesModel;
use CodeIgniter\Controller;

class CountriesController extends Controller
{
    private $countriesModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->countriesModel = new CountriesModel();
    }

    public function index()
	{
		$countries = $this->countriesModel->orderBy('id', 'ASC')->paginate(20);
        $data = [ 'countries' => $countries, 
                  'pager'=>$this->countriesModel->pager, 
                  'title' => 'Countries List'
                ];

		return view('Admin/Countries/list', $data);
	}



    public function edit($id){
        $country = $this->countriesModel->find($id);
        
        $data = [ 'country' => $country, 'title' => 'Edit country'];
        return view('Admin/Countries/edit', $data);
    }



    public function update(){
        $rules = [
            'name_english' => 'required|min_length[3]|max_length[20]',
            'alpha2' => 'required',
            ];

        if (! $this->validate($rules)) {
            
            return redirect()->to('/countries/edit/'.$this->request->getPost('id'))->withInput()->with('errors', $this->validator);
        }else{
            $newData = [
                        'id' => $this->request->getPost('id'),
                        'active' => $this->request->getPost('active'),
                        'alpha2' => $this->request->getPost('alpha2'),
                        'alpha3' => $this->request->getPost('alpha3'),
                        'preferred' => $this->request->getPost('preferred'),
                        'name_english' => $this->request->getPost('name_english'),
                        'name_french' => $this->request->getPost('name_french'),
                        'name_german' => $this->request->getPost('name_german'),
                        'name_italian' => $this->request->getPost('name_italian'),
                        'name_portuguese' => $this->request->getPost('name_portuguese'),
                        'name_russian' => $this->request->getPost('name_russian'),
                        'name_spanish' => $this->request->getPost('name_spanish'),
                        'name_romanian' => $this->request->getPost('name_romanian'),
                        'name_hungarian' => $this->request->getPost('name_hungarian'),

                        'name_chinese' => $this->request->getPost('name_chinese'),
                        'name_arabic' => $this->request->getPost('name_arabic'),
                        'region_code' => $this->request->getPost('region_code'),
                        'region_name' => $this->request->getPost('region_name'),
                        'sub_region_code' => $this->request->getPost('sub_region_code'),
                        'sub_region_name' => $this->request->getPost('sub_region_name'),
                        'intermediate_region_name' => $this->request->getPost('intermediate_region_name'),
                        'continent' => $this->request->getPost('continent'),
                        'is_eu' => $this->request->getPost('is_eu'),

                        ];
            
            $this->countriesModel->save($newData);

            session()->setFlashdata('success', 'Successfuly Updated');
            return redirect()->to('/countries/list');

        }
    }


  
}
