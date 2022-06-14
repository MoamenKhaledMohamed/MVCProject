<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleWare extends BaseMiddleWare
{
    private array $actions;
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    /**
     * @throws ForbiddenException
     */
    public function execute()
    {
        // TODO: Implement execute() method.
        if(Application::$app->isGuest()){
            if(empty($this->actions) || in_array(Application::$app->action, $this->actions))
                throw new ForbiddenException();
        }
    }
}