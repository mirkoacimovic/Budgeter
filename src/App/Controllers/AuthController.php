<?php

namespace App\Controllers;

use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class AuthController
{
    public function __construct(private TemplateEngine $view, private ValidatorService $validatorService, private UserService $userService)
    {
    }

    public function register()
    {
        echo $this->view->render('/register.php');
    }

    public function login()
    {
        $this->validatorService->validateLogin($_POST);
        $this->userService->login($_POST);
        redirectTo('/');
    }

    public function loginView()
    {
        echo $this->view->render('/login.php');
    }

    public function registerView()
    {
        var_dump($_POST);

        $this->validatorService->validateRegister($_POST);
        $this->userService->isEmailTaken($_POST['email']);
        $this->userService->create($_POST);
        redirectTo('/');
    }

    public function logout()
    {
        $this->userService->logout();
        redirectTo('/login');
    }
}
