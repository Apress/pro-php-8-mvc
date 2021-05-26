<?php

namespace Framework\Database\Migration\Field;

use Framework\Database\Exception\MigrationException;

class TextField extends Field
{
    public ?string $default = null;

    public function nullable(): static
    {
        throw new MigrationException('Text fields cannot be non-nullable');
    }

    public function default(string $value): static
    {
        $this->default = $value;
        return $this;
    }
}
