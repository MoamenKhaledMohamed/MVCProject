<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    protected Model $model;
    protected string $attribute;

    public function __construct($model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function renderInput(): string;

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf('<div class="form-group">
        <label for="full_name" class="form-label">%s</label>
         %s 
        </div><label class="is-invalid">%s</label>',
            $this->model->getLabels($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }

}