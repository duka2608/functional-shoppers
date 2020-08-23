<?php
    define('BASE_URL', 'http://localhost/shoppers/');
    define('ABSOLUTE_PATH', $_SERVER['DOCUMENT_ROOT'].'/shoppers');

    define('ENV_FILE', ABSOLUTE_PATH.'/config/.env');
    define('LOG_FILE', ABSOLUTE_PATH.'/data/log.txt');

    define('DBNAME', env('DATABASE'));
    define('SERVER', env('SERVER'));
    define('USER', env('USERNAME'));
    define('PASSWORD', env('PASSWORD'));

    function env($name){
        $open = fopen(ENV_FILE, "r");
        $data = file(ENV_FILE);
        $string = "";

        foreach($data as $key => $value){
            $config = explode("=", $value);
            if($config[0] == $name){
                $string = trim($config[1]);
            }
        }
        return $string;
    }