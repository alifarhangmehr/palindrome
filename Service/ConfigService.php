<?php

namespace Service;

class ConfigService
{
    public function __construct()
    {

    }

    public function getMysqlConfig()
    {
        //todo move this to .env and use phpdotenv
        return [
            'host' => 'mysql',
            'user' => 'root',
            'password' => 'root',
            'db' => 'app',
            'port' => 3306
        ];
    }
}
