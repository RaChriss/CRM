<?php

namespace app\controllers;

use Flight;

class UserController
{

    public function __construct() {}

    public function showLogin()
    {
        Flight::render('pages/login');
    }

    public function authenticate()
    {
        $generaliserModel = Flight::generaliserModel();
        $result = $generaliserModel->checkLogin('user', ['user_id', 'department_id'], 'POST', ['user_id', 'name', 'department_id']);
        if ($result['success']) {
            $_SESSION['department_id'] = $result['data']['department_id'];
            $_SESSION['name'] = $result['data']['name'];
            $_SESSION['user_id'] = $result['data']['user_id'];
            if ($result['data']['department_id'] == 1) {
                Flight::redirect('admin');
            } else if ($result['data']['department_id'] == 5) {
                Flight::redirect('client');
            } else {
                Flight::redirect('home');
            }
        } else {
            Flight::render('pages/login', ['error' => $result['message']]);
        }
    }

    public function logout()
    {
        session_destroy();
        Flight::redirect('.');
    }
}
