<?php

namespace Model;

require_once 'Model.php';

use Model\Model as BaseModel;

class UserModel extends BaseModel
{

    /** @var int $id */
    public $id;

    /** @var string $username */
    public $username;

    /** @var string $password */
    public $password;

    /** @var string $firstName */
    public $firstName;

    /** @var string $lastName */
    public $lastName;

    /** @var string $emailAddress */
    public $emailAddress;

    /** @var string $token */
    public $token;

    /** @var array $editable */
    private $editable;

    /** @var array $required */
    private $required;

    /**
     * UserModel constructor.
     * @param int|null $id
     * @param string|null $username
     * @param string|null $password
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $emailAddress
     * @param string|null $token
     */
    public function __construct(int $id = null, string $username = null, string $password = null, string $firstName = null, string $lastName = null, string $emailAddress = null, string $token = null)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->emailAddress = $emailAddress;
        $this->token = $token;
        $this->required = [
            'username',
            'password',
            'firstName',
            'lastName',
        ];
        $this->editable = [
            'firstName',
            'lastName',
            'emailAddress'
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return parent::convertToJson($this);
    }

    /**
     * @return array
     */
    public function getRequired() : array
    {
        return $this->required;
    }

    /**
     * @return array
     */
    public function getEditable() : array
    {
        return $this->editable;
    }
}
