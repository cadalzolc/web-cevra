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
            'server'=> 'localhost',
            'database'=> 'db',
            'username'=> 'root',
            'password'=> 'pass', // Leave blank if no password
        ],
        'prod' => [
            'server'=> 'server',
            'database'=> 'db',
            'username'=> 'root',
            'password'=> 'pass',
        ],
        '*' => [
            'maileraddress'=> 'mailer@gmail.com',
            'mailerpassword'=> '123456789',
        ]
    ];

    public static function Setting($name){
        return  self::settings[self::GetEnvironment()][$name] ?? self::settings['*'][$name];
    }

}
?>
