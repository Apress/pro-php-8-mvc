<?php

namespace Framework\Database\Migration\Field;

class BoolField extends Field
{
    public ?bool $default = null;

    public function default(bool $value): static
    {
        $this->default = $value;
        return $this;
    }
}
