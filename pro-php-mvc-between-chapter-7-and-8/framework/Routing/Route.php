<?php

namespace Framework\Routing;

class Route
{
    protected string $method;
    protected string $path;
    protected $handler;
    protected array $parameters = [];
    protected ?string $name = null;

    public function __construct(string $method, string $path, $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function parameters(): array
    {
        return $this->parameters;
    }

    public function name(string $name = null)
    {
        if ($name) {
            $this->name = $name;
            return $this;
        }

        return $this->name;
    }

    public function matches(string $method, string $path): bool
    {
        if (
            $this->method === $method
            && $this->path === $path
        ) {
            return true;
        }

        $parameterNames = [];

        $pattern = $this->normalisePath($this->path);

        $pattern = preg_replace_callback('#{([^}]+)}/#', function (array $found) use (&$parameterNames) {
            array_push($parameterNames, rtrim($found[1], '?'));

            if (str_ends_with($found[1], '?')) {
                return '([^/]*)(?:/?)';    
            }

            return '([^/]+)/';
        }, $pattern);

        if (
            !str_contains($pattern, '+')
            && !str_contains($pattern, '*')
        ) {
            return false;
        }

        preg_match_all("#{$pattern}#", $this->normalisePath($path), $matches);

        $parameterValues = [];

        if (count($matches[1]) > 0) {
            foreach ($matches[1] as $value) {
                if ($value) {
                    array_push($parameterValues, $value);
                    continue;
                }

                array_push($parameterValues, null);
            }

            $emptyValues = array_fill(0, count($parameterNames), false);
            $parameterValues += $emptyValues;

            $this->parameters = array_combine($parameterNames, $parameterValues);

            return true;
        }

        return false;
    }

    private function normalisePath(string $path): string
    {
        $path = trim($path, '/');
        $path = "/{$path}/";
        $path = preg_replace('/[\/]{2,}/', '/', $path);

        return $path;
    }

    public function dispatch()
    {
        if (is_array($this->handler)) {
            [$class, $method] = $this->handler;

            if (is_string($class)) {
                return (new $class)->{$method}();
            }

            return $class->{$method}();
        }

        return call_user_func($this->handler);
    }
}
