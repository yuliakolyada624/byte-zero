<?php
namespace App\Modules\User\Entities;

use App\Modules\Orders\Models\OrdersModel;
use CodeIgniter\Shield\Entities\User;
use App\Modules\Companies\Models\CompaniesModel;
use App\Modules\Countries\Models\CountriesModel;

class UserEntitie extends User
{
    
    public $company_name;
    public $country_name;
    // public $country_a2code;
    public $company_domain;


    /**
     * @return mixed
     */
    public function getUserCompanyName()
    {
        
        if ($this->company_name === null) {
            /** @var CompaniesModel $CompaniesModel */
            $companiesModel = model(CompaniesModel::class);
            $company = $companiesModel->find($this->company_id);
            if(isset($company->company_name)){
                $this->company_name = $company->company_name;
            }
            
            return $this->company_name;
        }

        return $this->company_name;
    }

    public function getUserCompanyDomain()
    {
        
        if ($this->company_domain === null) {
            /** @var CompaniesModel $CompaniesModel */
            $companiesModel = model(CompaniesModel::class);
            $company = $companiesModel->find($this->company_id);
            if(isset($company->domain)){
                $this->company_domain = $company->domain;
            }
            
            return $this->company_domain;
        }

        return $this->company_domain;
    }


    public function getUserRoleName()
    {
        if (isset($this->groups)) {
            $groups = config('AuthGroups')->groups;
            $names = [];
            foreach ($this->groups as $group) {
                $names[] = $groups[$group]['title'];
            }

            return implode(", ", $names);
        }

        return;
    }


    public function getUserCountryName()
    {
        
        if ($this->country_name === null) {
            
            $CountriesModel = model(CountriesModel::class);
            $country = $CountriesModel->find($this->country);
            if(isset($country->name_english)){
                $this->country_name = $country->name_english;
            }
            
            return $this->country_name;
        }
    }

    // public function getUserCountryA2Code()
    // {
        
    //     if ($this->country_name === null) {
            
    //         $CountriesModel = model(CountriesModel::class);
    //         $country = $CountriesModel->find($this->country);
    //         if(isset($country->alpha2)){
    //             $this->country_a2code = $country->alpha2;
    //         }
            
    //         return $this->country_a2code;
    //     }
    // }


    public function getUserCasesCount($type)
    {
        $ordersModel = model(OrdersModel::class);
        $cnt = $ordersModel->getOrdersCountByClaimType($type, $this->id);
        return $cnt;
    }


}