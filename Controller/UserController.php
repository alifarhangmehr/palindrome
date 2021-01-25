<?php

namespace Controller;

require_once './Service/UserService.php';
require_once './Model/UserModel.php';
require_once 'APIController.php';

use Service\UserService;
use Model\UserModel;

class UserController extends APIController
{
    /** @var UserService $userService */
    private $userService;

    /** @var UserModel $userModel */
    private $user;

    /**
     * UserController constructor.
     * @param $request
     */
    public function __construct($request)
    {
        parent::__construct($request);

        $this->userService = new UserService();
        $this->user = new UserModel();
    }

    /**
     * @return string
     */
    public function login(): string
    {
        $requestBody = json_decode($this->request->getBody());

        if (empty($requestBody->username) || empty ($requestBody->password)) {
            return $this->jsonResponse(400, 'Both username and password fields are required.');
        }

        $user = $this->userService->login($requestBody->username, $requestBody->password);

        if (!empty($user)) {
            return $this->jsonResponse(200, $user);
        }

        return $this->jsonResponse(401, 'Wrong credential(s).');
    }

    /**
     * @return string
     */
    public function createUser(): string
    {
        $requestBody = json_decode($this->request->getBody());

        $errors = $this->validateUserRequiredFields($requestBody);
        if (!empty($errors)) {
            return $this->jsonResponse(400, implode(', ', $errors));
        }

        $token = $this->generateToken();
        $username = isset($requestBody->username) ? $requestBody->username : null;
        $password = isset($requestBody->password) ? $requestBody->password : null;
        $firstName = isset($requestBody->firstName) ? $requestBody->firstName : null;
        $lastName = isset($requestBody->lastName) ? $requestBody->lastName : null;
        $emailAddress = isset($requestBody->emailAddress) ? $requestBody->emailAddress : null;

        $this->user = new UserModel(null, $username, $password, $firstName, $lastName, $emailAddress, $token);

        if (!$this->userService->isUsernameUnique($this->user->username)) {
            return $this->jsonResponse(409, "Sorry, but the username $username is taken, please try another one.");
        }

        $result = $this->userService->create($this->user);
        if ($result) {
            return $this->jsonResponse(200, "The user has been created successfully.");
        }
        return $this->generalErrorJsonResponse();
    }

    /**
     * @param $requestBody
     * @return array
     */
    private function validateUserRequiredFields($requestBody): array
    {
        $errors = [];

        foreach ($this->user->getRequired() as $required) {
            if (empty($requestBody->$required)) {
                $errors[] = $required . " field is required";
            }
        }
        return $errors;
    }

    /**
     * @return string
     */
    private function generateToken(): string
    {
        //todo update this, there is not guarantee the token is unique
        return md5(uniqid(rand(), true));
    }

    /**
     * @return string
     */
    public function editUser(): string
    {
        if (!$this->authenticate()) {
            return $this->invalidBearerTokenResponse();
        }

        $requestBody = json_decode($this->request->getBody());

        if (!$this->validateEditUserRequest($requestBody)) {
            return $this->jsonResponse(400,
                "At list one of user editable field should be sent: " . implode(", ", $this->user->getEditable()));
        }

        $firstName = isset($requestBody->firstName) ? $requestBody->firstName : null;
        $lastName = isset($requestBody->lastName) ? $requestBody->lastName : null;
        $emailAddress = isset($requestBody->emailAddress) ? $requestBody->emailAddress : null;
        $token = $this->getBearerTokenFromRequest($this->request);

        $result = $this->userService->update($token, $firstName, $lastName, $emailAddress);
        if ($result) {
            return $this->jsonResponse("200", "The user has been successfully updated.");
        }
        return $this->generalErrorJsonResponse();
    }

    /**
     * @param $requestBody
     * @return bool
     */
    private function validateEditUserRequest($requestBody) : bool
    {
        foreach ($this->user->getEditable() as $editable) {
            if (isset($requestBody->$editable)) {
                return true;
            }
        }
        return false;
    }
}
