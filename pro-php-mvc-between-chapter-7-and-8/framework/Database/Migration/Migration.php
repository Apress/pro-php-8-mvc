<?php

namespace Framework\Database\Migration;

use Framework\Database\Connection\Connection;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;

abstract class Migration
{
    protected array $fields = [];

    public function bool(string $name): BoolField
    {
        $field = $this->fields[] = new BoolField($name);
        return $field;
    }

    public function dateTime(string $name): DateTimeField
    {
        $field = $this->fields[] = new DateTimeField($name);
        return $field;
    }

    public function float(string $name): FloatField
    {
        $field = $this->fields[] = new FloatField($name);
        return $field;
    }

    public function id(string $name): IdField
    {
        $field = $this->fields[] = new IdField($name);
        return $field;
    }

    public function int(string $name): IntField
    {
        $field = $this->fields[] = new IntField($name);
        return $field;
    }

    public function string(string $name): StringField
    {
        $field = $this->fields[] = new StringField($name);
        return $field;
    }

    public function text(string $name): TextField
    {
        $field = $this->fields[] = new TextField($name);
        return $field;
    }

    abstract public function execute();
    abstract public function dropColumn(string $name): static;
}
