<?php

declare (strict_types = 1);

namespace app\core\forms;

/**
 * Undocumented class
 */
class TextareaField extends BaseField
{
    /**
     * Undocumented function
     *
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf('<textarea class="form-control%s" name="%s">%s</textarea>',
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->attribute,
            $this->model->{$this->attribute},
        );
    }
}
