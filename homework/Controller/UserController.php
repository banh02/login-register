<?php

require_once 'Model/User.php';

class UserController
{
    public function __construct()
    {
        $this->userDB = new User();
    }

    public function sendResponse($status, $message, $data = null)
    {
        http_response_code($status);
        $response = [
            'status' => $status === 200 || $status === 201 ? 'success' : 'error',
            'message' => $message,
            "backBtn" => "<a style='display:block;text-align:center;border:1px solid black;text-decoration:none;color:black;font-weight:bold;margin-top:16px;padding:8px;'href='javascript:history.back()'>Back</a>"

        ];
        echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function login()
    {
        $username = $_POST['username'] ?? "";
        $password = $_POST['password'] ?? "";

        $inputData = json_decode(file_get_contents('php://input'), true);

        if (isset($inputData['username']) && isset($inputData['password'])) {
            $username = $inputData['username'];
            $password = $inputData['password'];
        }

        $user = new User();
        $user->username = $username;
        $user->pass = $password;
        $userCheck = $user->getUser();
        if (count($userCheck) > 0)
            if ($userCheck[0]->password == $password) {
                $_SESSION['username'] = $userCheck[0]->username;
                self::sendResponse(200, "Login successfully {$userCheck[0]->id}");
            } else
                self::sendResponse(401, "Wrong password!");
        else
            self::sendResponse(404, "User not found!");
    }


    public function register()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if ($data !== null) {
            $username = $data['username'];
            $password = $data['password'];
        }

        $user = new User();
        $user->username = $username;
        $user->password = $password;

        if (count($user->getUser()) > 0)
            self::sendResponse(409, "Username already exists!");

        if ($user->insert())
            self::sendResponse(201, "user created successfully");
        else
            self::sendResponse(500, "Failed to create user!");
    }

    public function logout()
    {
        unset($_SESSION['username']);
        if (!isset($_SESSION['username']))
            self::sendResponse(200, "Logout successfully");
        else
            self::sendResponse(400, "Logout failed!");
    }

}
