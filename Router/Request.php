<?php

require_once 'IRequest.php';
require_once './Helper/StringHelper.php';

use Helper\StringHelper;

class Request implements IRequest
{
    /**
     * Request constructor.
     */
    function __construct()
    {
        $this->bootstrapSelf();
    }

    private function bootstrapSelf()
    {
        foreach ($_SERVER as $key => $value) {
            $this->{StringHelper::snackCaseToCamelCase($key)} = $value;
        }
    }

    /**
     * @return array|void
     */
    public function getBody()
    {
        switch ($this->requestMethod) {
            case 'GET':
                return;
                break;
            case 'OPTIONS':
            case 'POST':
            case 'PATCH':
                return file_get_contents('php://input');
                break;
            default:
                return;
        }
    }
}
