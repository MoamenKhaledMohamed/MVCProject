<?php

namespace app\core\form;

class TextAreaField extends BaseField
{

    public function __construct($model, $attribute)
    {
        parent::__construct($model, $attribute);
    }


    public function renderInput(): string
    {
        // TODO: Implement renderInput() method.
        return sprintf('<textarea class="form-control %s"  name="%s">%s</textarea>',
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }
}