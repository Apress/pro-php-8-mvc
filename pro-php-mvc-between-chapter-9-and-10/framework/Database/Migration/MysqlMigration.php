<?php

namespace Framework\Database\Migration;

use Framework\Database\Connection\MysqlConnection;
use Framework\Database\Exception\MigrationException;
use Framework\Database\Migration\Field\Field;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;

class MysqlMigration extends Migration
{
    protected MysqlConnection $connection;
    protected string $table;
    protected string $type;
    protected array $drops = [];

    public function __construct(MysqlConnection $connection, string $table, string $type)
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->type = $type;
    }

    public function execute()
    {
        $fields = array_map(fn($field) => $this->stringForField($field), $this->fields);

        $primary = array_filter($this->fields, fn($field) => $field instanceof IdField);
        $primaryKey = isset($primary[0]) ? "PRIMARY KEY (`{$primary[0]->name}`)" : '';

        if ($this->type === 'create') {
            $fields = join(PHP_EOL, array_map(fn($field) => "{$field},", $fields));

            $query = "
                CREATE TABLE `{$this->table}` (
                    {$fields}
                    {$primaryKey}
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
            ";
        }

        if ($this->type === 'alter') {
            $fields = join(PHP_EOL, array_map(fn($field) => "{$field};", $fields));
            $drops = join(PHP_EOL, array_map(fn($drop) => "DROP COLUMN `{$drop}`;", $this->drops));

            $query = "
                ALTER TABLE `{$this->table}`
                {$fields}
                {$drops}
            ";
        }

        $statement = $this->connection->pdo()->prepare($query);
        $statement->execute();
    }

    private function stringForField(Field $field): string
    {
        $prefix = '';

        if ($this->type === 'alter') {
            $prefix = 'ADD';
        }

        if ($field->alter) {
            $prefix = 'MODIFY';
        }

        if ($field instanceof BoolField) {
            $template = "{$prefix} `{$field->name}` tinyint(4)";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default !== null) {
                $default = (int) $field->default;
                $template .= " DEFAULT {$default}";
            }

            return $template;
        }

        if ($field instanceof DateTimeField) {
            $template = "{$prefix} `{$field->name}` datetime";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default === 'CURRENT_TIMESTAMP') {
                $template .= " DEFAULT CURRENT_TIMESTAMP";
            } else if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof FloatField) {
            $template = "{$prefix} `{$field->name}` float";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof IdField) {
            return "{$prefix} `{$field->name}` int(11) unsigned NOT NULL AUTO_INCREMENT";
        }

        if ($field instanceof IntField) {
            $template = "{$prefix} `{$field->name}` int(11)";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof StringField) {
            $template = "{$prefix} `{$field->name}` varchar(255)";

            if ($field->nullable) {
                $template .= " DEFAULT NULL";    
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";    
            }

            return $template;
        }

        if ($field instanceof TextField) {
            return "{$prefix} `{$field->name}` text";
        }

        throw new MigrationException("Unrecognised field type for {$field->name}");
    }

    public function dropColumn(string $name): static
    {
        $this->drops[] = $name;
        return $this;
    }
}
