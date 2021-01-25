<?php

namespace wrappers;

require_once 'Service/ConfigService.php';

use Service\ConfigService;

class MysqlDatabase
{
    /** @var array $config */
    private $config;

    /** @var \mysqli $db */
    private $db;

    public function __construct()
    {
        $configService = new ConfigService();
        $this->config = $configService->getMysqlConfig();
        $this->db = new \mysqli($this->config['host'], $this->config['user'], $this->config['password'],
            $this->config['db'], $this->config['port']);
    }

    public function query(string $query)
    {
        $result = $this->db->query($query);

        //for insert and update
        if (is_bool($result)) {
            return $result;
        }
        return new MysqlResult($result);
    }
}
