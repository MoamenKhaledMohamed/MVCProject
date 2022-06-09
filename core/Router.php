<?php


namespace app\core;



class Router
{
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    protected array $routes = [];

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

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
           return $this->renderView('_404');
        }

        // check view or function
        if(is_string($callback)){
            // render the view
           return $this->renderView($callback);
        }

        // if callback is an array so create instance from class
        if(is_array($callback)){
            $callback[0] = new $callback[0];
            Application::$app->controller = $callback[0];
        }

        // execute the function if it is a real function
        // or an array contains an instance of class and function.
        return call_user_func($callback, $this->request);
    }

    public function renderView(string $view, array $params = [])
    {
        // render layout
        $layout = $this->renderLayout();

        // render view
        $view = $this->renderOnlyView($view, $params);

        // replace content with view
        return str_replace('{{content}}', $view, $layout);

    }

    private function renderLayout()
    {
        $layout = Application::$app->controller->layout;
        // store html in buffer
        ob_start();
        include_once Application::$ROOTPATH."/views/layouts/$layout.php";
        // return html and clean the buffer
        return ob_get_clean();
    }

    private function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $param){
            $$key = $param;

        }
        // store html in buffer
        ob_start();
        include_once Application::$ROOTPATH."/views/$view.php";
        // return html then clean the buffer
        return ob_get_clean();
    }

}