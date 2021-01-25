<?php

namespace Model;

require_once 'ModelInterface.php';

use Model\ModelInterface;

class Model implements ModelInterface
{
    public function __construct()
    {

    }

    public function convertToJson($model)
    {
        $jsonArray = [];
        foreach ($model as $key => $value) {
            $jsonArray[$key] = $value;
        }
        return json_encode($jsonArray);
    }

    public function getEditable()
    {
        return [];
    }

    public function getRequired()
    {
        return [];
    }
}
