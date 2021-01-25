<?php

require_once __DIR__."/../vendor/autoload.php";
use app\core\Application;

// create object from app
$app = new Application();

$app->router->get('/', function(){
    return "Hello World";
});
$app->run();