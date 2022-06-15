<?php

namespace app\core\form;

class Form
{
    public static function begin(string $action, string $method): Form
    {
        echo sprintf('<form action="%s" method="%s">',
            $action, $method);
        return new Form();
    }

    public static function end(): string
    {
        return '</form>';
    }

    public function inputField($model, $attribute): InputField
    {
       return new InputField($model, $attribute);
    }

    public function textAreaField($model, $attribute): TextAreaField
    {
        return new TextAreaField($model, $attribute);
    }
}