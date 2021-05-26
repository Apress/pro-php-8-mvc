<?php

namespace Framework\Validation\Rule;

use InvalidArgumentException;

class MinRule implements Rule
{
    public function validate(array $data, string $field, array $params)
    {
        if (empty($data[$field])) {
            return true;
        }

        if (empty($params[0])) {
            throw InvalidArgumentException('specify a min length');
        }

        $length = (int) $params[0];

        strlen($data[$field]) >= $length;
    }

    public function getMessage(array $data, string $field, array $params)
    {
        $length = (int) $params[0];

        return "{$field} should be at least {$length} characters";
    }
}
