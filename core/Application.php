<?php


namespace app\core;


class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    public static string $ROOTPATH;
    public Controller $controller;

    public function __construct($rootPath)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        self::$ROOTPATH = $rootPath;
        self::$app = $this;
    }

    public function run()
    {
       echo $this->router->resolve();
    }

}