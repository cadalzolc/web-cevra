<?php
class Configuration {

    private static $environment;

    public static function GetEnvironment()
    {
        if(empty(Configuration::$environment))
        {
            switch($_SERVER['SERVER_NAME'])
            {
                case 'speshvenue.com':
                case 'speshvenue-com.preview-domain.com':
                        Configuration::$environment = 'prod'; break;
                case '2a02:4780:3:545:0:1cee:3931:2':
                    Configuration::$environment = 'prod'; break;
                default:
                    Configuration::$environment = 'dev'; break;
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
            'server'          => '151.106.117.0',
            'database'          => 'u485374257_cevra',
            'username'            => 'u485374257_root',
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