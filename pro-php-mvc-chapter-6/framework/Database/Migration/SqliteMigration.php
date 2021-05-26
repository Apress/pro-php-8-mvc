<?php

namespace Framework\Database\Migration;

use Framework\Database\Connection\SqliteConnection;
use Framework\Database\Exception\MigrationException;
use Framework\Database\Migration\Field\Field;
use Framework\Database\Migration\Field\BoolField;
use Framework\Database\Migration\Field\DateTimeField;
use Framework\Database\Migration\Field\FloatField;
use Framework\Database\Migration\Field\IdField;
use Framework\Database\Migration\Field\IntField;
use Framework\Database\Migration\Field\StringField;
use Framework\Database\Migration\Field\TextField;

class SqliteMigration extends Migration
{
    protected SqliteConnection $connection;
    protected string $table;
    protected string $type;

    public function __construct(SqliteConnection $connection, string $table, string $type)
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->type = $type;
    }

    public function execute()
    {
        $command = $this->type === 'create' ? '' : 'ALTER TABLE';

        $fields = array_map(fn($field) => $this->stringForField($field), $this->fields);

        if ($this->type === 'create') {
            $fields = join(',' . PHP_EOL, $fields);

            $query = "
                CREATE TABLE \"{$this->table}\" (
                    {$fields}
                );
            ";
        }

        if ($this->type === 'alter') {
            $fields = join(';' . PHP_EOL, $fields);

            $query = "
                ALTER TABLE \"{$this->table}\"
                {$fields};
            ";
        }

        $statement = $this->connection->pdo()->prepare($query);
        $statement->execute();
    }

    private function stringForField(Field $field): string
    {
        $prefix = '';

        if ($this->type === 'alter') {
            $prefix = 'ADD COLUMN';
        }

        if ($field->alter) {
            throw new MigrationException('SQLite doesn\'t support altering columns');
        }

        if ($field instanceof BoolField) {
            $template = "{$prefix} \"{$field->name}\" INTEGER";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default !== null) {
                $default = (int) $field->default;
                $template .= " DEFAULT {$default}";
            }

            return $template;
        }

        if ($field instanceof DateTimeField) {
            $template = "{$prefix} `{$field->name}` TEXT";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default === 'CURRENT_TIMESTAMP') {
                $template .= " DEFAULT CURRENT_TIMESTAMP";
            } else if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";
            }

            return $template;
        }

        if ($field instanceof FloatField) {
            $template = "{$prefix} `{$field->name}` REAL";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT {$field->default}";
            }

            return $template;
        }

        if ($field instanceof IdField) {
            return "{$prefix} `{$field->name}` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE";
        }

        if ($field instanceof IntField) {
            $template = "{$prefix} `{$field->name}` INTEGER";

            if (!$field->nullable) {
                $template .= " NOT NULL";
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT {$field->default}";
            }

            return $template;
        }

        if ($field instanceof StringField || $field instanceof TextField) {
            $template = "{$prefix} `{$field->name}` TEXT";

            if (!$field->nullable) {
                $template .= " NOT NULL";    
            }
            
            if ($field->default !== null) {
                $template .= " DEFAULT '{$field->default}'";    
            }

            return $template;
        }

        throw new MigrationException("Unrecognised field type for {$field->name}");
    }

    public function dropColumn(string $name): static
    {
        throw new MigrationException('SQLite doesn\'t support dropping columns');
    }
}
