<?php

namespace Framework\Database\QueryBuilder;

use Framework\Database\Connection\Connection;
use Framework\Database\Exception\QueryException;
use Pdo;
use PdoStatement;

abstract class QueryBuilder
{
    protected string $type;
    protected string $columns;
    protected string $table;
    protected int $limit;
    protected int $offset;

    /**
     * Fetch all rows matching the current query
     */
    public function all(): array
    {
        $statement = $this->prepare();
        $statement->execute();

        return $statement->fetchAll(Pdo::FETCH_ASSOC);
    }

    /**
     * Prepare a query against a particular connection
     */
    public function prepare(): PdoStatement
    {
        $query = '';

        if ($this->type === 'select') {
            $query = $this->compileSelect($query);
            $query = $this->compileLimit($query);
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
        $query .= " SELECT {$this->columns} FROM {$this->table}";

        return $query;
    }

    /**
     * Add limit and offset clauses to the query
     */
    protected function compileLimit(string $query): string
    {
        if ($this->limit) {
            $query .= " LIMIT {$this->limit}";
        }

        if ($this->offset) {
            $query .= " OFFSET {$this->offset}";
        }

        return $query;
    }

    /**
     * Fetch the first row matching the current query
     */
    public function first(): array
    {
        $statement = $this->take(1)->prepare();
        $statement->execute();

        return $statement->fetchAll(Pdo::FETCH_ASSOC);
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
    public function select(string $columns = '*'): static
    {
        $this->type = 'select';
        $this->columns = $columns;

        return $this;
    }
}
