<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;
use App\Filters\Auth;

class Filters extends BaseFilters
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, class-string|list<class-string>>
     *
     * [filter_name => classname]
     * or [filter_name => [classname1, classname2, ...]]
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth' 		    => Auth::class,
        //'lang' 		=> \App\Filters\Lang::class,
    ];
    
        /**
     * List of special required filters.
     *
     * The filters listed here are special. They are applied before and after
     * other kinds of filters, and always applied even if a route does not exist.
     *
     * Filters set by default provide framework functionality. If removed,
     * those functions will no longer work.
     *
     * @see https://codeigniter.com/user_guide/incoming/filters.html#provided-filters
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            'forcehttps', // Force Global Secure Requests
            'pagecache',  // Web Page Caching
        ],
        'after' => [
            'pagecache',   // Web Page Caching
            'performance', // Performance Metrics
            'toolbar',     // Debug Toolbar
        ],
    ];

    

	// Always applied before every request
	public array $globals = [
		'before' => [
			//'honeypot'
			'csrf' => ['except' => ['reports/get_ai_response']],
			//'lang',
            'session' => ['except' => [
                                        'accounts/*',
                                        'accounts/login*', 
                                        'accounts/register', 
                                        'accounts/logout',  
                                        'accounts/set-new-password', 
                                        'accounts/auth/a/show', 
                                        'accounts/onboarding/*', 
                                        'reports/get_ai_response']],             
		],
		'after'  => [
			'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'POST' => ['CSRF', 'throttle'],
	public array $methods = [
		//'POST' => ['csrf'],
	];     

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public array $filters = [
		'auth' => ['before' => ['admin/*', 'user/*', 'currencies/list', 'currencies/edit', 'countries/*', 
					/* FRONT */
					'account/*',
                    'dashboard/*',
                    'cases/*',
                    'orders/*',
                    'transactions/*',
                    'user-management/*',
					],
					
				], 
				['except' => ['accounts/*']]
	];
}
