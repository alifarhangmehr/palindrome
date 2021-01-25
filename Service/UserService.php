<?php

namespace Service;

require_once 'MysqlService.php';
require_once './Model/UserModel.php';

use Model\UserModel;
use Service\MysqlService;

class UserService
{
    /** @var MysqlService $mysqlService */
    private $mysqlService;

    public function __construct()
    {
        $this->mysqlService = new MysqlService();
    }

    /**
     * @param string $username
     * @param string $password
     * @return string|null
     */
    public function login(string $username, string $password)
    {
        $hashPassword = $this->getHashedPassword($password);

        //todo move this to gateway
        $query = "SELECT * FROM user WHERE username = '$username' AND password = '$hashPassword'";
        $result = $this->mysqlService->query($query);

        if (is_bool($result)) {
            return $result;
        }
        if (count($result) > 0) {

            $result = $result[array_key_first($result)];
            $user = new UserModel((int)$result['id'], $result['username'], $result['password'], $result['firstName'], $result['lastName'], $result['emailAddress'], $result['token']);
            return $user->toJson();
        }
        return null;
    }

    /**
     * @param string $password
     * @return string
     */
    public function getHashedPassword(string $password) : string
    {
        //todo move salt to .env
        $salt = "saltySalt";

        return hash('sha256', $password . $salt);
    }

    public function refreshToken()
    {
        //todo
    }

    /**
     * @param string $token
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $emailAddress
     * @return bool
     */
    public function update(string $token, ?string $firstName = null, ?string $lastName = null, ?string $emailAddress = null): bool
    {
        $userId = $this->getUserIdByToken($token);

        if (is_null($userId)) {
            return false;
        }

        $query = "UPDATE user SET ";

        $updateArray = [];
        if (!empty($firstName)) {
            $updateArray[] = "first_name = '$firstName'";
        }

        if (!empty($lastName)) {
            $updateArray[] = "last_name = '$lastName'";
        }

        if (!empty($emailAddress)) {
            $updateArray[] = "email_address = '$emailAddress'";
        }

        $query .= implode(', ', $updateArray);
        $query .= " WHERE id = '$userId'";

        return $this->mysqlService->query($query);
    }

    /**
     * @param string $token
     * @return int|null
     */
    private function getUserIdByToken(string $token) : ?int
    {
        $query = "SELECT id FROM user WHERE token = '$token'";
        $result = $this->mysqlService->query($query);
        if (count($result)) {
            return $result[array_key_first($result)]['id'];
        }
        return null;
    }

    /**
     * @param UserModel $user
     * @return bool
     */
    public function create(UserModel $user) : bool
    {
        $hashedPassword = $this->getHashedPassword($user->password);
        $query = "INSERT INTO user (username, password, first_name, last_name, email_address, token) VALUES ('$user->username', '$hashedPassword', '$user->firstName', '$user->lastName', '$user->emailAddress', '$user->token')";
        return $this->mysqlService->query($query);
    }

    /**
     * @param string $username
     * @return bool
     */
    public function isUsernameUnique(string $username) : bool
    {
        $query = "SELECT id FROM user WHERE username = '$username'";
        $result = $this->mysqlService->query($query);
        return !$result;
    }

    /**
     * TODO future update: token need its own table, model, service
     * @param string $token
     * @return bool
     */
    public function validateToken(string $token) : bool
    {
        $query = "SELECT token FROM user WHERE token = '$token'";
        $result = $this->mysqlService->query($query);

        if (is_bool($result)) {
            return $result;
        }

        return count($result) > 0;
    }

}
