<?php

namespace Framework\Validation\Rule;

class RequiredRule implements Rule
{
    public function validate(array $data, string $field, array $params)
    {
        return !empty($data[$field]);
    }

    public function getMessage(array $data, string $field, array $params)
    {
        return "{$field} is required";
    }
}
