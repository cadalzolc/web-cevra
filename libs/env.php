<?php
class Configuration {

    private static $environment;
    
    public static function GetEnvironment(){
        if(empty(Configuration::$environment)){
            switch($_SERVER['SERVER_NAME']){
                case 'speshvenue.com':
                    Configuration::$environment = 'prod';
                default:
                    Configuration::$environment = 'dev';
            }
        }
        return Configuration::$environment;
    }

    public const settings = [
        "dev" => [
            'server'          => 'localhost',
            'database'          => 'db_events',
            'username'            => 'root',
            'password'        => '',
        ],
        'prod' => [
            'server'          => 'sql445.main-hosting.eu',
            'database'          => 'u485374257_cevra',
            'username'            => 'u485374257_cevra',
            'password'        => 'P@ssw0rd.22',
        ],
        '*' => [
            'maileraddress'        => 'mailer@gmail.com',
            'mailerpassword'        => '123456789',
            'dbdebug'           => false,
            'trace'             => false
        ]
    ];

    public static function Setting($name){
        return  self::settings[self::GetEnvironment()][$name] ?? self::settings['*'][$name];
    }

}
?>