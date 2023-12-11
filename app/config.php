<?php
require_once 'app/core/App.php';

$devConnection = array(
    'host' => "localhost",
    'username' => "root",
    'password' => "",
    'db_name' => "personal_mvc"
);

$prodConnection = array(
    'host' => "127.0.0.1",
    'username' => "",
    'password' => "",
    'db_name' => ""
);

$GLOBALS['config'] = array(
    'app' => array(
        'name' => 'APP_NAME',
        'bridal_shop_email' => 'APP_EMAIL',
    ),
    'mysql' => \app\core\App::isProduction() ? $prodConnection : $devConnection,
    'password' => array(
        'algo_name' => PASSWORD_DEFAULT,
        'cost' => 10,
        'salt' => 50,
    ),
    'hash' => array(
        'algo_name' => 'sha512',
        'salt' => 30,
    ),
    'remember' => array(
        'cookie_name' => 'token',
        'cookie_expiry' => 604800
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'csrf_token'
    ),
    'sms' => array(
        // 'account_sid' => 'ACc863dc6d01b3ccdfdc162068b128aa1c',
        // 'auth_token' => 'e94ab8fac949e83e582ff7646b54b3a9',
        // 'from_number' => '12564742822'
    )
);
