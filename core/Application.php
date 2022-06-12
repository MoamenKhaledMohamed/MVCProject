<?php


namespace app\core;


class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public DataBase $db;
    public Session $session;
    public static Application $app;
    public static string $ROOTPATH;
    public Controller $controller;

    public function __construct(string $rootPath, array $config)
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new DataBase($config['db']);
        self::$ROOTPATH = $rootPath;
        self::$app = $this;
    }

    public function run()
    {
       echo $this->router->resolve();
    }

}