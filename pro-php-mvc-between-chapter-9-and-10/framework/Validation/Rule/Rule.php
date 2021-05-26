<?php

namespace Framework\Validation\Rule;

interface Rule
{
    public function validate(array $data, string $field, array $params);
    public function getMessage(array $data, string $field, array $params);
}
