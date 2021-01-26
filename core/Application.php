<?php


namespace app\core;


class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public static string $ROOTPATH;

    public function __construct($rootPath)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        self::$ROOTPATH = $rootPath;
    }

    public function run()
    {
       echo $this->router->resolve();
    }

}