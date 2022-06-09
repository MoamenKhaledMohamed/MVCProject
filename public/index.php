<?php

require_once __DIR__."/../vendor/autoload.php";

use app\controllers\AuthController;
use app\core\Application;
use app\controllers\SiteController;

$app = new Application(dirname(__DIR__));
$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'handleLoginData']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);

$app->run();
//phpinfo();