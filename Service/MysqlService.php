<?php

namespace Service;

require_once 'ConfigService.php';
require_once 'wrappers/MysqlDatabase.php';
require_once 'wrappers/MysqlResult.php';

use Service\ConfigService;
use Helper\StringHelper;
use mysqli as MySqli;
use wrappers\MysqlDatabase;
use wrappers\MysqlResult;

class MysqlService
{
    /** @var MysqlDatabase $db */
    private $db;

    /**
     * MysqlService constructor.
     */
    public function __construct()
    {

        $this->db = new MysqlDatabase();
    }

    public function doSomething()
    {
        //remove this
    }

    /**
     * @param string $query
     * @return array|bool
     */
    public function query(string $query)
    {
        $result = $this->db->query($query);


        if (is_bool($result)) {
            return $result;
        }
        if ($result->getNumRows() == 0) {
            return false;
        }

        $resultArray = [];

        while ($row = $result->fetchAssoc()) {
            $rowArray = [];
            foreach ($row as $key => $value) {
                $rowArray[StringHelper::snackCaseToCamelCase($key)] = $value;
            }
            $resultArray[] = $rowArray;
        }
        return $resultArray;
    }

    public function resetAndSeedMysql()
    {
        //todo update this
        $structureQuery = file_get_contents('./sql/structure.sql');
        $result = $this->db->query($structureQuery);

        $dataQuery = file_get_contents('./sql/data.sql');
        $result1 = $this->db->query($dataQuery);

        if ($result) {
            echo 'User table either created or already exists. <br />';
        }

        if ($result1) {
            echo 'User has been created. <br />';
        } else {
            echo 'User already exists. <br />';
        }
    }
}
