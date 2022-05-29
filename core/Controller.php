<?php


namespace app\core;


class Controller
{
    protected function render($view)
    {
      return Application::$app->router->renderView($view);
    }
}