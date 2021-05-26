<?php

namespace Framework\Validation\Exception;

use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    protected array $errors = [];
    protected string $sessionName = 'errors';

    public function setErrors(array $errors): static
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setSessionName(string $sessionName): static
    {
        $this->sessionName = $sessionName;
        return $this;
    }

    public function getSessionName(): string
    {
        return $this->sessionName;
    }
}
