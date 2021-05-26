<?php

namespace Framework\Database\Migration\Field;

class DateTimeField extends Field
{
    public ?string $default = null;

    public function default(string $value): static
    {
        $this->default = $value;
        return $this;
    }
}
