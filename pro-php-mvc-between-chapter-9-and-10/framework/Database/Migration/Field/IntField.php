<?php

namespace Framework\Database\Migration\Field;

class IntField extends Field
{
    public ?int $default = null;

    public function default(int $value): static
    {
        $this->default = $value;
        return $this;
    }
}
