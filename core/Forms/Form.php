<?php

declare (strict_types = 1);

namespace app\core\forms;

use app\core\Model;

/**
 * Undocumented class
 */
class Form
{
    /**
     * Undocumented function
     *
     * @param string $action
     * @param string $method
     * @param array $options
     * @return Form
     */
    public static function begin(string $action, string $method, array $options = []): Form
    {
        $attributes = [];
        foreach ($options as $key => $value) {
            $attributes[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, implode(" ", $attributes));
        return new Form();
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public static function end(): void
    {
        echo '</form>';
    }

    /**
     * Undocumented function
     *
     * @param Model $model
     * @param string $attribute
     * @return Field
     */
    public function field(Model $model, string $attribute): Field
    {
        return new Field($model, $attribute);
    }

}
