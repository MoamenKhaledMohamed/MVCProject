<?php


namespace app\core;



use app\core\exceptions\NotFoundException;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @throws NotFoundException
     */
    public function resolve()
    {
        // get path from url without ?
        $path = $this->request->getPath();

        // get type of method
        $method = $this->request->method();

        // return the callback function from array routes
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false){
            // make the status code is 404
            $this->response->setStatusCode(404);
            throw new NotFoundException();
        }

        // check view or function
        if(is_string($callback)){
            // render the view
           return Application::$app->view->renderView($callback);
        }

        // if callback is an array so create instance from class
        if(is_array($callback)){
            $callback[0] = new $callback[0];
            Application::$app->controller = $callback[0];
            Application::$app->action = $callback[1];
            foreach (Application::$app->controller->getMiddleWares() as $middleWare)
                $middleWare->execute();
        }

        // execute the function if it is a real function
        // or an array contains an instance of class and function.
        return call_user_func($callback, $this->request,  $this->response);
    }


}