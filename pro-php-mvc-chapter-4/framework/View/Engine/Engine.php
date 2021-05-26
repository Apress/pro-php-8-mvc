<?php

namespace Framework\View\Engine;

use Framework\View\Manager;
use Framework\View\View;

interface Engine
{
    // public function render(string $path, array $data = []): string;
    public function render(View $view): string;
    public function setManager(Manager $manager): static;
}
