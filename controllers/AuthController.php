<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout("auth");
       return $this->render('login');
    }

    public function handleLoginData(Request $request)
    {
         $request->getBody();

    }

    public function handleRegisterData(Request $request)
    {

    }

    public function register()
    {
        return $this->render('register');
    }
}