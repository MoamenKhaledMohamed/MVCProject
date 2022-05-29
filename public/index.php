<?php

require_once __DIR__."/../vendor/autoload.php";
use app\core\Application;
use app\controllers\SiteController;

$app = new Application(dirname(__DIR__));
$app->router->get('/home', 'home');
$app->router->get('/', function(){
    return "Hello From Function";
});
//$app->router->get('/home', [SiteController::class, 'home']);
$app->run();