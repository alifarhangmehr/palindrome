<?php

require_once 'Router/Request.php';
require_once 'Router/Router.php';

use Controller\PalindromeController;
use Controller\UserController;
use Service\MysqlService;

$router = new Router(new Request);

$router->get('/', function() {
    header("Location: /public/index.php", true, 200);
});

$router->post('/v1/palindromes', function($request) {
    require_once 'Controller/PalindromeController.php';
    $palindromeController = new PalindromeController($request);
    return $palindromeController->isPalindrome($request);
});

$router->post('/v1/login', function($request) {
    require_once 'Controller/UserController.php';
    $userController = new UserController($request);
    return $userController->login();
});

$router->post('/v1/users', function($request) {
    require_once 'Controller/UserController.php';
    $userController = new UserController($request);
    return $userController->createUser();
});

$router->patch('/v1/users', function($request) {
    require_once 'Controller/UserController.php';
    $userController = new UserController($request);
    return $userController->editUser();
});

$router->get('/reset_db', function() {
    require_once 'Service/MysqlService.php';
    $mysqlService = new MysqlService();
    $mysqlService->resetAndSeedMysql();
});
