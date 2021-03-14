<?php

declare(strict_types=1);

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    // public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    /**
     * Here we check the given ($_POST) data and associate it with the model property if they exists
     * @param $data
     */
    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * @return array
     */
    abstract public function rules(): array;


    public function validate(): bool
    {
        foreach ($this->rules() as $attrib => $rules) {
            $val = $this->{$attrib};
            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                // The error checker
                if ($ruleName === self::RULE_REQUIRED && !$val) {
                    $this->addError($attrib, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && filter_var($val, FILTER_VALIDATE_EMAIL) === false) {
                    $this->addError($attrib, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($val) < $rule['min']) {
                    $this->addError($attrib, self::RULE_MIN, $rule);
                }
                if ($ruleName === self::RULE_MAX && strlen($val) > $rule['max']) {
                    $this->addError($attrib, self::RULE_MAX, $rule);
                }
                if ($ruleName === self::RULE_MATCH && $val !== $this->{$rule['match']}) {
                    $this->addError($attrib, self::RULE_MATCH, $rule);
                }
            }
        }
        return empty($this->errors);
    }

    /**
     * @param string $attrib
     * @param string $rule
     * @param array $params
     */
    private function addError(string $attrib, string $rule, $params = []): void
    {
        $message = $this->errorMessages()[$rule] ?? '';

        foreach ($params as $key => $val) {
            $message = str_replace("{{$key}}", $val, $message);
        }
        $this->errors[$attrib][] = $message;
    }

    /**
     * @return string[]
     */
    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must contain a valid email address',
            self::RULE_MIN => 'Min length of field is {min}',
            self::RULE_MAX => 'Max length of field is {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
        ];
    }
}
