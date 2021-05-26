<?php

namespace Framework\View;

use Closure;
use Exception;
use Framework\View\Engine\Engine;
use Framework\View\View;

class Manager
{
    protected array $paths = [];
    protected array $engines = [];
    protected array $macros = [];

    public function addPath(string $path): static
    {
        array_push($this->paths, $path);
        return $this;
    }

    public function addEngine(string $extension, Engine $engine): static
    {
        $this->engines[$extension] = $engine;
        $this->engines[$extension]->setManager($this);
        return $this;
    }

    public function resolve(string $template, array $data = []): View
    {
        foreach ($this->engines as $extension => $engine) {
            foreach ($this->paths as $path) {
                $file = "{$path}/{$template}.{$extension}";

                if (is_file($file)) {
                    return new View($engine, realpath($file), $data);
                }
            }
        }

        throw new Exception("Could not resolve '{$template}'");
    }

    public function addMacro(string $name, Closure $closure): static
    {
        $this->macros[$name] = $closure;
        return $this;
    }

    public function useMacro(string $name, ...$values)
    {
        if (isset($this->macros[$name])) {
            $bound = $this->macros[$name]->bindTo($this);
            return $bound(...$values);
        }

        throw new Exception("Macro isn't defined: '{$name}'");
    }
}
