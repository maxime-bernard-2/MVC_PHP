<?php

declare (strict_types=1);

namespace app\core\form;

use app\core\Model;

/**
 * Undocumented class
 */
class Field extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_PASSWORD = 'password';
    const TYPE_FILE = 'file';

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<input type="%s" class="form-control%s" name="%s" value="%s">',
            $this->type,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }

    /**
     * Undocumented function
     *
     * @return Field
     */
    public function passwordField(): Field
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return Field
     */
    public function fileField(): Field
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }
}