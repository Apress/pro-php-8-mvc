<?php

namespace Framework\Database\Connection;

use Framework\Database\Migration\Migration;
use Framework\Database\QueryBuilder\QueryBuilder;
use Pdo;

abstract class Connection
{
    /**
     * Get the underlying Pdo instance for this connection
     */
    abstract public function pdo(): Pdo;

    /**
     * Start a new query on this connection
     */
    abstract public function query(): QueryBuilder;

    /**
     * Start a new migration to add a table on this connection
     */
    abstract public function createTable(string $table): Migration;

    /**
     * Start a new migration to add a table on this connection
     */
    abstract public function alterTable(string $table): Migration;

    /**
     * Return a  list of table names on this connection
     */
    abstract public function getTables(): array;

    /**
     * Find out if a table exists on this connection
     */
    abstract public function hasTable(string $name): bool;

    /**
     * Drop all tables in the current database
     */
    abstract public function dropTables(): int;
}
