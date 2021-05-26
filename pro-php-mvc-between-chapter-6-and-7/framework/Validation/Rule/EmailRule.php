<?php

namespace Framework\Validation\Rule;

class EmailRule implements Rule
{
    public function validate(array $data, string $field, array $params)
    {
        if (empty($data[$field])) {
            return true;
        }

        return str_contains($data[$field], '@');
    }

    public function getMessage(array $data, string $field, array $params)
    {
        return "{$field} should be an email";
    }
}
