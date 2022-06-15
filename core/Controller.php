<?php


namespace app\core;



use app\core\middlewares\BaseMiddleWare;

class Controller
{
    public string $layout = "main";
    /**
     * @var BaseMiddleWare[]
     */
    private array $middleWares = [];

    public function setLayout(string $layout)
    {
       $this->layout = $layout;
    }

    protected function render($view, $params = [])
    {
      return Application::$app->view->renderView($view, $params);
    }

    protected function registerMiddleWares(BaseMiddleWare $middleWare)
    {
        $this->middleWares[] = $middleWare;
    }

    public function getMiddleWares(): array
    {
        return $this->middleWares;
    }
}