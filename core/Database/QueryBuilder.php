<?php

namespace Core\Database;

class QueryBuilder
{
    private $select = [];

    private $conditions = [];

    private $from = [];

    public function select()
    {
        $this->select = func_get_args();
        return $this;
    }

    public function where()
    {
        foreach (func_get_args() as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function from($table, $alias)
    {
        if (is_null($alias))
            $this->from[] = "$table";
        else
            $this->from[] = "$table AS $alias";
        return $this;
    }

    public function getQuery()
    {
        return 'SELECT ' . implode(', ', $this->select)
            . ' FROM ' . implode(', ', $this->from)
            . ' WHERE ' . implode(' AND ', $this->conditions);
    }
}
