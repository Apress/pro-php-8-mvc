<?php

namespace Framework\Validation;

use Framework\Validation\Exception\ValidationException;
use Framework\Validation\Rule\Rule;

class Manager
{
    protected array $rules = [];

    public function addRule(string $alias, Rule $rule): static
    {
        $this->rules[$alias] = $rule;
        return $this;
    }

    public function validate(array $data, array $rules, string $sessionName = 'errors'): array
    {
        $errors = [];

        foreach ($rules as $field => $rulesForField) {
            foreach ($rulesForField as $rule) {
                $name = $rule;
                $params = [];

                if (str_contains($rule, ':')) {
                    [$name, $params] = explode(':', $rule);
                    $params = explode(',', $params);
                }
                
                $processor = $this->rules[$name];

                if (!$processor->validate($data, $field, $params)) {
                    if (!isset($errors[$field])) {
                        $errors[$field] = [];
                    }

                    array_push($errors[$field], $processor->getMessage($data, $field, $params));
                }
            }
        }

        if (count($errors)) {
            $exception = new ValidationException();
            $exception->setErrors($errors);
            $exception->setSessionName($sessionName);
            throw $exception;
        } else {
            if ($session = session()) {
                $session->forget($sessionName);
            }
        }

        return array_intersect_key($data, $rules);
    }
}
