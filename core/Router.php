<?php


namespace app\core;


class Router
{
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    protected array $routes = [];

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        // get path from url without ?
        $path = $this->request->getPath();

        // get type of method
        $method = $this->request->getMethod();

        // return the callback function from array routes
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            echo "Not Found";
            exit;
        }
        // execute the funcution
        echo call_user_func($callback);
    }

}