<?php

require_once 'Controller/UserController.php';
$request = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [""];
session_start();


$userController = new UserController();

if (isset($request[0])) {
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            if (!isset($_SESSION['username'])) {
                include 'View/login.php';
            } else {
                include 'View/home.php';
            }
            break;
        case 'POST':
            if ($request[0] === 'login') {
                $userController->login();
            } elseif ($request[0] === 'register') {
                $userController->register();
            } elseif ($request[0] === 'logout') {
                $userController->logout();
            }
            break;
        default:
            break;
    }
} else {
    echo "No valid action provided in the path.";
}

?>