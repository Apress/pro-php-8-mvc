<?php

namespace Framework\Validation;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    protected array $errors = [];

    public function setErrors(array $errors): static
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
