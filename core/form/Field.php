<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    private const TYPE_TEXT = 'text';
    private const TYPE_PASSWORD = 'password';
    private const TYPE_NUMBER = 'number';
    private Model $model;
    private string $attribute;
    private string $type;

    public function __construct($model, $attribute)
    {
       $this->type = self::TYPE_TEXT;
       $this->model = $model;
       $this->attribute = $attribute;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return sprintf('<div class="form-group">
        <label for="full_name" class="form-label">%s</label>
        <input type="%s" class="form-control %s" id="fullName" name="%s" value="%s">
        </div><label class="is-invalid">%s</label>',
        $this->model->getLabels($this->attribute),
            $this->type,
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->getFirstError($this->attribute)
        );
    }

    public function typePassword(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }
}