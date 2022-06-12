<?php


namespace app\controllers;


use app\core\Controller;
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
class SiteController extends Controller
{
    public function home()
    {
        $params = [
           "name" => "User"
        ];
       return $this->render('home', $params);
    }
}