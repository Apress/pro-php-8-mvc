<?php

namespace Framework\Database;

use Framework\Database\QueryBuilder\QueryBuilder;

class ModelCollector
{
    private QueryBuilder $builder;
    private string $class;

    public function __construct(QueryBuilder $builder, string $class)
    {
        $this->builder = $builder;
        $this->class = $class;
    }

    public function __call(string $method, array $parameters = []): mixed
    {
        $result = $this->builder->$method(...$parameters);

        // in case it's a fluent method...
        if ($result instanceof QueryBuilder) {
            $this->builder = $result;
            return $this;
        }

        return $result;
    }

    public function first()
    {
        $class = $this->class;

        $row = $this->builder->first();

        if (!is_null($row)) {
            $row = $class::with($row);
        }

        return $row;
    }

    public function all()
    {
        $class = $this->class;

        $rows = $this->builder->all();

        foreach ($rows as $i => $row) {
            $rows[$i] = $class::with($row);
        }

        return $rows;
    }
}
