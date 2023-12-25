<?php

namespace app\core;

use app\core\utils\DateHelper;

class Model extends Database
{
    protected $table;

    public function __construct($table = null)
    {
        parent::__construct();

        if ($table) {
            $className = (new \ReflectionClass($this))->getShortName();
            $this->table = strtolower($className) . 's';
        }
    }

    public function all()
    {
        $this->query("SELECT * FROM {$this->table}");

        return $this->resultSet();
    }

    public function getById($id)
    {
        $this->query("SELECT * FROM {$this->table} WHERE id = :id");
        $this->bind(':id', $id);
        return $this->single();
    }

    public function getByField($field, $value)
    {
        $this->query("SELECT * FROM {$this->table} WHERE {$field} = :value");
        $this->bind(':value', $value);
        return $this->resultSet();
    }

    public static function _create($data)
    {
        $instance = new static();
        $instance->create($data);
        return $instance;
    }

    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $this->query("INSERT INTO {$this->table} ({$columns}) VALUES ({$values})");

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }

        return $this->execute();
    }

    public function update($id, $data)
    {
        $setClause = '';
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ', ');

        $this->query("UPDATE {$this->table} SET $setClause WHERE id = :id");
        $this->bind(':id', $id);

        foreach ($data as $key => $value) {
            $this->bind(":$key", $value);
        }

        return $this->execute();
    }

    public function delete($id)
    {
        $this->query("DELETE FROM {$this->table} WHERE id = :id");
        $this->bind(':id', $id);
        return $this->execute();
    }

    public function customQuery($sql, $params = [])
    {
        $this->query($sql);

        foreach ($params as $param => $value) {
            $this->bind($param, $value);
        }

        return $this->execute();
    }

    public function createTable($table, array $fields)
    {
        if (empty($fields)) {
            // Handle error: No fields provided
            return false;
        }

        // Construct the SQL query for creating the table
        $sql = "CREATE TABLE IF NOT EXISTS {$table} (";
        foreach ($fields as $fieldName => $fieldType) {
            $sql .= "$fieldName $fieldType, ";
        }
        $sql = rtrim($sql, ', '); // Remove the trailing comma
        $sql .= ")";

        // Execute the query
        $this->query($sql);

        return $this->execute();
    }


    public function dropTable($table)
    {
        // Construct the SQL query for dropping the table
        $sql = "DROP TABLE IF EXISTS {$table}";

        // Execute the query
        $this->query($sql);

        return $this->execute();
    }
}
