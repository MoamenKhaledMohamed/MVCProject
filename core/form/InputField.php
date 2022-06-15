<?php

namespace app\core\form;

use app\core\middlewares\BaseMiddleWare;
use app\core\Model;

class InputField extends BaseField
{
    private const TYPE_TEXT = 'text';
    private const TYPE_PASSWORD = 'password';
    private const TYPE_NUMBER = 'number';
    private string $type;

    public function __construct($model, $attribute)
    {
       $this->type = self::TYPE_TEXT;
       parent::__construct($model, $attribute);
    }


    public function typePassword(): InputField
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function renderInput(): string
    {
        // TODO: Implement renderInput() method.
        return sprintf('<input type="%s" class="form-control %s" id="fullName" name="%s" value="%s">',
            $this->type,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );

    }
}