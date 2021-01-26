<?php

require_once __DIR__."/../vendor/autoload.php";
use app\core\Application;

// create object from app
$app = new Application(dirname(__DIR__));

//$app->router->get('/home', function(){
//    return "hello from /home";
//});


$app->router->get('/', 'home');
$app->router->get('/contact', 'contact');

$app->run();