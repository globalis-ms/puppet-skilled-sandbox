<?php

$unix_username = exec('whoami');
$git_name      = exec('git config user.name');
$git_email     = exec('git config user.email');
$project_slug  = 'puppet_skilled_sandbox';

return [
    // Local Config
    'local' => [
        'GIT_PATH' => [
            'question' => 'Path to git',
            'default' => 'git',
        ],
        'NPM_PATH' => [
            'question' => 'Path to npm',
            'default' => 'npm',
        ],
        'BOWER_PATH' => [
            'question' => 'Path to bower',
            'default' => 'bower',
        ],
        'GULP_PATH' => [
            'question' => 'Path to gulp',
            'default' => 'gulp',
        ],

        /**
         * USER
         */
        'DEVELOPER_MAIL' => [
            'question' => 'Developer email',
            'default'  => $git_email,
        ],

        'DEVELOPER_NAME' => [
           'question' => 'Developer name',
           'default'  => $git_name,
        ],
    ],

    // Project constante
    'settings' => [
        'PROJECT_NAME' => $project_slug,
        'SEEDS_FOLDER' => 'seeds',
        'EMAIL_STORE' => 'false',
    ],

    // Project configuration
    'config' => [
        /**
         * DATABASE
         */
        'DB_NAME' => [
            'question' => 'Database name',
            'default' => $unix_username . '_' . $project_slug,
        ],
        'DB_USER' => [
            'question' => 'Database username',
            'default' => 'username',
        ],
        'DB_PASSWORD' => [
            'question' => 'Database password',
            'default' => 'password',
        ],
        'DB_HOST' => [
            'question' => 'Database Host',
            'default' => 'localhost',
        ],
        'DB_PORT' => [
            'question' => 'Database port',
            'default' => 3306
        ],

        /**
         * CI CONF
         */
        'ENVIRONEMENT' => [
            'question' => 'Environment',
            'choices' => ['development', 'testing', 'production'],
            'default' => 'development'
        ],
        'WEB_SCHEME' => [
            'question' => 'Site scheme',
            'choices' => ['http', 'https'],
            'default' => 'http',
        ],
        'WEB_HOST' => [
            'question' => 'Site host',
            'default' => 'example.com',
        ],
        'WEB_PATH' => [
            'question' => 'Site base path',
            'default' => '/'.$unix_username.'/'.$project_slug,
            'empty' => true,
        ],
        'COOKIE_SECURE' => [
            'question' => 'Cookie will only be set if a secure HTTPS connection exists. ',
            'choices' => ['false', 'true'],
            'default' => 'false',
            'if' => function(array $currentConfig) {
                return $currentConfig['WEB_SCHEME'] !== 'http';
            },
        ],

        /**
         * Email Config
         */
         'EMAIL_PROTOCOL' => [
            'question' => 'Email protocol',
            'choices' => ['mail', 'sendmail', 'smtp'],
            'default' => 'mail',
         ],
         'EMAIL_HOST' => [
            'question' => 'Email server address',
            'default' => '',
            'empty' => true,
            'if' => function(array $currentConfig) {
                return $currentConfig['EMAIL_PROTOCOL'] === 'smtp';
            },
         ],
         'EMAIL_PORT' => [
            'question' => 'Email server port',
            'default' => '25',
            'if' => function(array $currentConfig) {
                return $currentConfig['EMAIL_PROTOCOL'] === 'smtp';
            },
         ],
    ]
];
