<?php

declare(strict_types=1);

namespace Config;

use CodeIgniter\Shield\Config\AuthGroups as ShieldAuthGroups;

class AuthGroups extends ShieldAuthGroups
{
    /**
     * --------------------------------------------------------------------
     * Default Group
     * --------------------------------------------------------------------
     * The group that a newly registered user is added to.
     */
    public string $defaultGroup = 'superadmin';

    /**
     * --------------------------------------------------------------------
     * Groups
     * --------------------------------------------------------------------
     * The available authentication systems, listed
     * with alias and class name. These can be referenced
     * by alias in the auth helper:
     *      auth('api')->attempt($credentials);
     */
    public array $groups = [
        'system' => [
            'title'       => 'System',
            'description' => 'Complete control of the site.',
        ],
        'superadmin' => [
            'title'       => 'Super Administrator',
            'description' => 'Highest system permissions level within all Business Units',
        ],
        'administrator' => [
            'title'       => 'Administrator',
            'description' => 'Top user access level enables customization of site settings, analytics, billing, user management',
        ],
        'assignee' => [
            'title'       => 'Assignee',
            'description' => '',
        ],
        'reviewer' => [
            'title'       => 'Reviewer',
            'description' => '',
        ],
        'approver' => [
            'title'       => 'Approver',
            'description' => '',
        ],        
    ];


    public array $invite_groups = [
        'administrator' => [
            'title'       => 'Administrator',
            'description' => 'Top user access level enables customization of site settings, analytics, billing, user management.',
        ],
        'assignee' => [
            'title'       => 'Assignee',
            'description' => '',
        ],
        'reviewer' => [
            'title'       => 'Reviewer',
            'description' => '',
        ],
        'approver' => [
            'title'       => 'Approver',
            'description' => '',
        ],
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions
     * --------------------------------------------------------------------
     * The available permissions in the system. Each system is defined
     * where the key is the
     *
     * If a permission is not listed here it cannot be used.
     */
    public array $permissions = [
        'system.access'        => 'Complete system privileges.',

        'superadmin.access'   => 'Complete superadmin privileges.',
        
        'administrator.access'        => 'Complete admin privileges.',
        'administrator.users'         => 'Can control User access',
        'administrator.settings'      => 'Can define company and user management settings',
        'administrator.policies'      => 'Can Define travel policies',
        'administrator.reporting'     => 'Have access billing, analytics and reporting',

        'selfregistred.access'      => 'Selfregistred privileges.',
    ];

    /**
     * --------------------------------------------------------------------
     * Permissions Matrix
     * --------------------------------------------------------------------
     * Maps permissions to groups.
     */
    public array $matrix = [
        'system' => [
            'system.*',
            'superadmin.*',
            'administrator.*',
            'selfregistred.*'
        ],
        'superadmin' => [
            'superadmin.access',
            'administrator.*',
        ],
        'administrator' => [
            'administrator.access',
            'administrator.users',
            'administrator.settings',
            'administrator.book',
            'administrator.policies',
            'administrator.reporting',
        ],
        'selfregistred' => [
            'selfregistred.access', 
        ],
    ];
}
