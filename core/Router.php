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

    public function resolve()
    {
        // get path from url without ?
        $path = $this->request->getPath();

        // get type of method
        $method = $this->request->getMethod();

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

        // execute the function
        return call_user_func($callback);
    }

    private function renderView(string $view)
    {
        // render layout
        $layout = $this->renderLayout();

        // render view
        $view = $this->renderOnlyView($view);

        // replace content with view
        return str_replace('{{content}}', $view, $layout);
    }

    private function renderLayout()
    {
        // store html in buffer
        ob_start();
        include_once Application::$ROOTPATH."/views/layouts/main.php";

        // return html and clean the buffer
        return ob_get_clean();
    }

    private function renderOnlyView($view)
    {
        // store html in buffer
        ob_start();
        include_once Application::$ROOTPATH."/views/$view.php";

        // return html then clean the buffer
        return ob_get_clean();
    }

}