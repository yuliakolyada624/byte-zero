<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];


	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------

	public $user_registration = [
		'email' => [
            'label' =>  'Auth.email',
            'rules' => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret]',
        ],
       /* 'password' => [
            'label' =>  'Auth.password',
            'rules' => 'required',
        ],
        'password_confirm' => [
            'label' =>  'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],*/
		'first_name' => [
			'label' =>  'Auth.firstname',
			'rules' => 'required|trim',
		],
		'last_name' => [
			'label' =>  'Auth.lastname',
			'rules' => 'required|trim',
		],
		'middle_name' => [
			'label' =>  'Auth.middle_name',
			'rules' => 'max_length[254]',
		]	
		
		
    ];

	public $registration = [
		/*'username' => [
            'label' =>  'Auth.username',
            'rules' => 'required|max_length[30]|min_length[3]|regex_match[/\A[a-zA-Z0-9\.]+\z/]|is_unique[users.username]',
        ],*/
        'email' => [
            'label' =>  'Auth.email',
            'rules' => 'required|max_length[254]|valid_email|is_unique[auth_identities.secret]',
        ],
        'password' => [
            'label' =>  'Auth.password',
            'rules' => 'required',
        ],
        'password_confirm' => [
            'label' =>  'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
		'first_name' => [
			'label' =>  'Auth.firstname',
			'rules' => 'required|trim|min_length[3]',
		],
		'last_name' => [
			'label' =>  'Auth.lastname',
			'rules' => 'required|trim|min_length[3]',
		],
		'phone_number' => [
			'label' =>  'Auth.phone_number',
			'rules' => 'required|trim',
		],
		'country' => [
			'label' =>  'Auth.country',
			'rules' => 'trim',
		],
		'city' => [
			'label' =>  'Auth.country',
			'rules' => 'trim',
		],
		'address_line_1' => [
			'label' =>  'Auth.address_line_1',
			'rules' => 'trim',
		],
		'language' => [
			'label' =>  'Auth.language',
			'rules' => 'trim',
		],
		'currency' => [
			'label' =>  'Auth.currency',
			'rules' => 'trim',
		],
		'nationality' => [
			'label' =>  'Auth.nationality',
			'rules' => 'trim',
		],
		'state' => [
			'label' =>  'Auth.state',
			'rules' => 'trim',
		],
		'province' => [
			'label' =>  'Auth.province',
			'rules' => 'trim',
		],
		'zip_code' => [
			'label' =>  'Auth.zip_code',
			'rules' => 'trim',
		],
		'postal_code' => [
			'label' =>  'Auth.postal_code',
			'rules' => 'trim',
		],
		'exclude_notifications_from_header' => [
			'label' =>  'Auth.exclude_notifications_from_header',
			'rules' => 'if_exist',
		],
		'email_notifications_for_missed_alerts' => [
			'label' =>  'Auth.email_notifications_for_missed_alerts',
			'rules' => 'if_exist',
		]
		
    ];

}


class CustomRules{
	public function max_byte(?string $str, string $val): bool
    {
       // return is_numeric($val) && $val >= strlen($str ?? '');
	   return true;
    }

	public function current_password(string $password, ?string &$error = null): bool
    {
        $result = auth()->check([
            'email'    => auth()->user()->email,
            'password' => $password,
        ]);

        if( !$result->isOK() ) {
            // Send back the error message
            $error = lang('Auth.errorCurrentPassword');

            return false;
        }

        return true;
    } 

}
