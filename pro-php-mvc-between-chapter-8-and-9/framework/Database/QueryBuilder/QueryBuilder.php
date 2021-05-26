<?php

namespace Framework\Database\QueryBuilder;

use Framework\Database\Connection\Connection;
use Framework\Database\Exception\QueryException;
use Pdo;
use PdoStatement;

abstract class QueryBuilder
{
    protected string $type;
    protected array $columns;
    protected string $table;
    protected int $limit;
    protected int $offset;
    protected array $values;
    protected array $wheres = [];

    /**
     * Fetch all rows matching the current query
     */
    public function all(): array
    {
        if (!isset($this->type)) {
            $this->select();
        }

        $statement = $this->prepare();
        $statement->execute($this->getWhereValues());

        return $statement->fetchAll(Pdo::FETCH_ASSOC);
    }

    /**
     * Get the values for the where clause placeholders
     */
    protected function getWhereValues(): array
    {
        $values = [];

        if (count($this->wheres) === 0) {
            return $values;
        }

        foreach ($this->wheres as $where) {
            $values[$where[0]] = $where[2];
        }

        return $values;
    }

    /**
     * Prepare a query against a particular connection
     */
    public function prepare(): PdoStatement
    {
        $query = '';

        if ($this->type === 'select') {
            $query = $this->compileSelect($query);
            $query = $this->compileWheres($query);
            $query = $this->compileLimit($query);
        }

        if ($this->type === 'insert') {
            $query = $this->compileInsert($query);
        }

        if ($this->type === 'update') {
            $query = $this->compileUpdate($query);
            $query = $this->compileWheres($query);
        }

        if ($this->type === 'delete') {
            $query = $this->compileDelete($query);
            $query = $this->compileWheres($query);
        }

        if (empty($query)) {
            throw new QueryException('Unrecognised query type');
        }

        return $this->connection->pdo()->prepare($query);
    }

    /**
     * Add select clause to the query
     */
    protected function compileSelect(string $query): string
    {
        $joinedColumns = join(', ', $this->columns);

        $query .= " SELECT {$joinedColumns} FROM {$this->table}";

        return $query;
    }

    /**
     * Add limit and offset clauses to the query
     */
    protected function compileLimit(string $query): string
    {
        if (isset($this->limit)) {
            $query .= " LIMIT {$this->limit}";
        }

        if (isset($this->offset)) {
            $query .= " OFFSET {$this->offset}";
        }

        return $query;
    }

    /**
     * Add where clauses to the query
     */
    protected function compileWheres(string $query): string
    {
        if (count($this->wheres) === 0) {
            return $query;
        }

        $query .= ' WHERE';

        foreach ($this->wheres as $i => $where) {
            if ($i > 0) {
                $query .= ', ';
            }

            [$column, $comparator, $value] = $where;

            $query .= " {$column} {$comparator} :{$column}";
        }

        return $query;
    }

    /**
     * Add insert clause to the query
     */
    protected function compileInsert(string $query): string
    {
        $joinedColumns = join(', ', $this->columns);
        $joinedPlaceholders = join(', ', array_map(fn($column) => ":{$column}", $this->columns));

        $query .= " INSERT INTO {$this->table} ({$joinedColumns}) VALUES ({$joinedPlaceholders})";

        return $query;
    }

    /**
     * Add update clause to the query
     */
    protected function compileUpdate(string $query): string
    {
        $joinedColumns = '';

        foreach ($this->columns as $i => $column) {
            if ($i > 0) {
                $joinedColumns .= ', ';
            }

            $joinedColumns = " {$column} = :{$column}";
        }

        $query .= " UPDATE {$this->table} SET {$joinedColumns}";

        return $query;
    }

    /**
     * Add delete clause to the query
     */
    protected function compileDelete(string $query): string
    {
        $query .= " DELETE FROM {$this->table}";
        return $query;
    }

    /**
     * Fetch the first row matching the current query
     */
    public function first(): array
    {
        if (!isset($this->type)) {
            $this->select();
        }

        $statement = $this->take(1)->prepare();
        $statement->execute($this->getWhereValues());

        $result = $statement->fetchAll(Pdo::FETCH_ASSOC);

        if (count($result) === 1) {
            return $result[0];
        }

        return null;
    }

    /**
     * Limit a set of query results so that it's possible
     * to fetch a single or limited batch of rows
     */
    public function take(int $limit, int $offset = 0): static
    {
        $this->limit = $limit;
        $this->offset = $offset;

        return $this;
    }

    /**
     * Indicate which table the query is targetting
     */
    public function from(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Indicate the query type is a "select" and remember 
     * which fields should be returned by the query
     */
    public function select(mixed $columns = '*'): static
    {
        if (is_string($columns)) {
            $columns = [$columns];
        }

        $this->type = 'select';
        $this->columns = $columns;

        return $this;
    }

    /**
     * Insert a row of data into the table specified in the query
     * and return the number of affected rows
     */
    public function insert(array $columns, array $values): int
    {
        $this->type = 'insert';
        $this->columns = $columns;
        $this->values = $values;

        $statement = $this->prepare();

        return $statement->execute($values);
    }

    /**
     * Store where clause data for later queries
     */
    public function where(string $column, mixed $comparator, mixed $value = null): static
    {
        if (is_null($value) && !is_null($comparator)) {
            array_push($this->wheres, [$column, '=', $comparator]);
        } else {
            array_push($this->wheres, [$column, $comparator, $value]);
        }

        return $this;
    }

    /**
     * Insert a row of data into the table specified in the query
     * and return the number of affected rows
     */
    public function update(array $columns, array $values): int
    {
        $this->type = 'update';
        $this->columns = $columns;
        $this->values = $values;

        $statement = $this->prepare();

        return $statement->execute($this->getWhereValues() + $values);
    }

    /**
     * Get the ID of the last row that was inserted
     */
    public function getLastInsertId(): string
    {
        return $this->connection->pdo()->lastInsertId();
    }

    /**
     * Delete a row from the database
     */
    public function delete(): int
    {
        $this->type = 'delete';

        $statement = $this->prepare();

        return $statement->execute($this->getWhereValues());
    }
}
