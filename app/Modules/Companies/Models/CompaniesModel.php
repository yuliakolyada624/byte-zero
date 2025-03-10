<?php 

namespace App\Modules\Companies\Models;

use CodeIgniter\Model;

class CompaniesModel extends Model
{
    protected $table  = 'companies';
    protected $allowedFields  = [
        'owner_id',
        'company_name',
        'domain',
        'office_name',
        'legal_entity_name',
        'address_line_1', 
        'address_line_1_google_id', 
        'address_line_2', 
        'city', 
        'state_province_region', 
        'zip_postal_code', 
        'country',
        'time_format',
        'time_zone',
        'daylight_savings',
        'notifications_copy_email',
        'alert_superadmin_when_payment_method_nears_expiration',
        'service_industry',
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $returnType     = CompaniesModel::class;

    protected $afterFind = [];

    protected $validationRules = [
        'id' => [
            'label' => 'ID',
            'rules' => 'max_length[12]',
            'type'  => 'hidden'
        ],
        'company_name' => [
            'label' => 'Company name',
            'rules' => 'required|min_length[3]|max_length[255]'
        ],
        'domain' => [
            'label' => 'Company domain',
            'rules' => 'max_length[255]'
        ],
        'address_line_1' => [
            'label' => 'Address line 1',
            'rules' => 'max_length[255]'
        ],
        'address_line_1_google_id' => [
            'label' => 'Address line 1 Google ID',
            'rules' => 'max_length[100]'
        ],
        'address_line_2' => [
            'label' => 'Address line 2',
            'rules' => 'max_length[255]'
        ],
        'city' => [
            'label' => 'City',
            'rules' => 'max_length[100]'
        ],
        'state_province_region' => [
            'label' => 'State / Province / Region',
            'rules' => 'max_length[100]'
        ],
        'zip_postal_code' => [
            'label' => 'ZIP / Postal code',
            'rules' => 'max_length[20]'
        ],
        'country' => [
            'label' => 'Country',
            'rules' => 'required_with[city]|max_length[100]'
        ],
        'job_title' => [
            'label' => 'Job title',
            'rules' => 'max_length[100]'
        ]
    ];

}
