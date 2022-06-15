<?php

namespace app\core;

class View
{
    public string $title = 'NON TITLE';

    public function renderView(string $view, array $params = [])
    {
        $view = $this->renderOnlyView($view, $params);
        $layout = $this->renderLayout();
        return str_replace('{{content}}', $view, $layout);

    }

    private function renderLayout()
    {
        // in case when the url is wrong.
        $layout = Application::$app->layout;
        if(Application::$app->controller)
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