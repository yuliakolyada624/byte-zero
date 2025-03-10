<?php namespace App\Modules\Companies\Controllers;

use App\Controllers\BaseController;
use App\Modules\Companies\Models\CompaniesModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Validation\Exceptions\ValidationException;

class CompaniesController extends BaseController
{
    use ResponseTrait;
    private $companiesModel;
    private $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->companiesModel = new CompaniesModel();

        $user = auth()->user();
        if (!is_null($user)) {
            $this->user = $user;
        } else {
            return $this->failUnauthorized(lang('Auth.successLogout'));
        }
    }

    public function index()
	{
		$companies = $this->companiesModel->orderBy('id', 'ASC')->paginate(20);
        $data = [ 'companies' => $companies, 
                  'pager'=>$this->companiesModel->pager, 
                  'title' => 'Companies List'
                ];

		return view('Admin/Companies/list', $data);
	}




    public function edit($id){
        $company = $this->companiesModel->find($id);
        $owners = $this->getSuperAdmins();
        $validationRules = $this->companiesModel->getValidationRules();
        $visibleFields = array_keys($validationRules);
        //dd($visibleFields);
        $data = [ 'company' => $company, 'owners'=>$owners, 'title' => 'Edit company', 'validationRules'=>$validationRules, 'visibleFields'=>$visibleFields];
        return view('Admin/Companies/edit', $data);
    }


    public function create(){
        
        $data = [ 'company' => false, 'title' => 'Edit company'];
        return view('Admin/Companies/edit', $data);
    }



    public function update(){
        
        $rules = $this->companiesModel->getValidationRules(/*['except' => ['name']]*/);

        if (! $this->validate($rules)) {
            return redirect()->to('/companies/edit/'.$this->request->getPost('id'))
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        } else {

            $postData = $this->request->getPost();
            $newData = [];

            foreach ($postData as $key => $value) {
                if (array_key_exists($key, $rules) || $key=='id') {
                    $newData[$key] = $value;
                }
            }
    
            $this->companiesModel->save($newData);
    
            session()->setFlashdata('success', 'Successfully Updated');
            return redirect()->to('/companies/list');
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
		
		$res = $this->companiesModel->delete($id);
        if($res){
            $data = [
                'success' => true,
                'msg'     => 'The data deleted successfully',
            ];
        } else {
            $data = [
                'success' => false,
                'msg'     => 'Error deleting the data',
            ];
        }

        return $this->response->setJSON($data);
    }


    public function getSuperAdmins(){
        $UserModel = new \App\Modules\User\Models\UserModel();
        $users = $UserModel->getUsersByGroup('superadmin');
       // dd($users);
        return $users;
    }



    /* FRONT */


    public function getCompany($company_id){
        
        $company = $this->companiesModel->where('owner_id', $this->user->id)->where('id', $company_id)->first();
        return $this->respond(['success'=>true, 'company'=>$company], 200);
    }


    public function companyUpdate()
    {
        $CompaniesModel = new CompaniesModel();
        $rules = $CompaniesModel->getValidationRules(); /*['except' => ['name']]*/
        //dd($rules);
        if (! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
            //return $this->respond(['success'=>false, 'errors'=>$this->validator->getErrors()], 200);
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $data = $this->request->getPost($allowedPostFields);
        $data['owner_id'] = $this->user->id;

       // var_dump($data); die;
        
        try {
            $CompaniesModel->save($data);
        } catch (ValidationException $e) {
            return $this->fail($CompaniesModel->errors(), 400);
        }
        
        return $this->respond(['success'=>true], 200);
    }



    public function companiesList(){
        //superadmin
        if(!auth()->user()->can('superadmin.access')){
            session()->setFlashdata('error', lang('Auth.notHaveAccess'));
            return redirect()->to('/account/overview');
        }
        
        $CompaniesModel = new CompaniesModel();
		$CompaniesList = $CompaniesModel->where('owner_id', $this->user->id)->orderBy('id', 'ASC')->paginate(20);
    

        $data = [   'user' => $this->user, 
                    'CompaniesList'=>$CompaniesList, 
                    'pager'=> $CompaniesModel->pager, 
                    'title' => 'My Companies List', 
                    'bodyClass' => 'account-page header-offset' 
                ];
        return view('Account/Company/CompaniesList', $data);
    }


    public function companyCreate(){
        //superadmin
        if(!auth()->user()->can('superadmin.access')){
            session()->setFlashdata('error', lang('Auth.notHaveAccess'));
            return redirect()->to('/account/overview');
        }
        
    

        $data = [   'user' => $this->user, 
                    'title' => 'Create My Company', 
                    'bodyClass' => 'account-page header-offset' 
                ];
        return view('Account/Company/CompanyEdit', $data);
    }


    public function companySave()
    {
        $CompaniesModel = new CompaniesModel();
        $rules = $CompaniesModel->getValidationRules(); /*['except' => ['name']]*/
        //dd($rules);
        if (! $this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $data = $this->request->getPost($allowedPostFields);
        $data['owner_id'] = $this->user->id;

        //var_dump($data); die;
        
        try {
            $CompaniesModel->save($data);
        } catch (ValidationException $e) {
            return $this->fail($CompaniesModel->errors(), 400);
        }
        $company_id = $CompaniesModel->getInsertID();
        $this->setDefaultCompany($company_id);

        return $this->respond(['success'=>true, 'redirectUrl'=>url_to('/')], 200);
    }


    public function companyEdit($company_id){
        //superadmin
        if(!auth()->user()->can('superadmin.access')){
            session()->setFlashdata('error', lang('Auth.notHaveAccess'));
            return redirect()->to('/account/overview');
        }
        
        $CompaniesModel = new CompaniesModel();
        $company = $CompaniesModel->Where('id', $company_id)->Where('owner_id', $this->user->id)->first();


        $data = [   'user' => $this->user, 
                    'company' => $company, 
                    'title' => 'Edit My Company', 
                    'bodyClass' => 'account-page header-offset' 
                ];
        return view('Account/Company/CompanyEdit', $data);
    }


    public function signUpCompany(){
        //superadmin
        if(!auth()->user()->can('superadmin.access')){
            session()->setFlashdata('error', lang('Auth.notHaveAccess'));
            return redirect()->to('/');
        }

        $data = [   'user' => $this->user, 
                    'title' => 'Company Information', 
                ];
        return view('Account/Company/signUpCompany', $data);
    }


    public function setDefaultCompany($company_id){
        $currentUser = auth()->user();
        
        // Get the User Provider (UserModel by default)
        $users = auth()->getProvider();
        
        if($currentUser->inGroup('superadmin') && $currentUser->company_id==null){
            $currentUser->company_id = $company_id;
            $users->update($currentUser->id, $currentUser);
        }
         
        
    }
    
}
