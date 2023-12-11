<?php

namespace app\core;

class Database
{
    private static $_instance = null;
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private function __construct()
    {
        try {
            $this->_pdo = new \PDO(
                'mysql:host=' . Config::get('mysql/host') . ';' .
                    'dbname=' . Config::get('mysql/db_name'),
                Config::get('mysql/username'),
                Config::get('mysql/password')
            );
            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->_error = true;
            die($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new Database();
        }

        return self::$_instance;
    }



    public function performCustomQuery($sql)
    {
        if (!$this->query($sql)->error()) {
            return $this;
        }

        return false;
    }

    public function query($sql, $params = array())
    {
        $this->_error = false;

        if ($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;

            if (count($params)) {
                foreach ($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if ($this->_query->execute()) {
                $this->_results = $this->_query->fetchAll(\PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }

        return $this;
    }

    public function getRecordCount($table, $where, $options = [])
    {
        $data = $this->action('SELECT *', $table, $where, $options);

        return $data;
    }

    public function getRecordSum($table, $sum_of, $where, $options = [])
    {
        $data = $this->action('SELECT SUM(' . $sum_of . ')', $table, $where, $options);

        return $data;
    }

    public function join($table1, $table2, $joinCondition, $selectColumns = '*', $whereConditions = array(), $options = array())
    {
        $sql = "SELECT $selectColumns FROM $table1
             JOIN $table2 ON $joinCondition";

        if (!empty($whereConditions)) {
            $sql .= " WHERE ";
            $sql .= implode(" AND ", $whereConditions);
        }

        // Execute the query using the query method
        if (!$this->query($sql)->error()) {
            return $this;
        }

        return false;
    }

    public function action($action, $table, $where = array(), $options = array())
    {
        if (count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=', 'BETWEEN'); // Add 'BETWEEN' to the list of operators

            $field = $where[0];
            $operator = strtoupper($where[1]); // Convert the operator to uppercase
            $value = $where[2];


            if (in_array($operator, $operators)) {
                if ($operator === 'BETWEEN') {
                    // If the operator is 'BETWEEN', handle the BETWEEN logic
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND ?";
                    $value1 = $value[0]; // Assuming $value is an array with two elements
                    $value2 = $value[1]; // Assuming $value is an array with two elements

                    $data = array(
                        $value1,
                        $value2,
                    );

                    if (!empty($options['greatherThan'])) {
                        $sql .= " AND {$options['greatherThanField']} > ";
                        $sql .= "{$options['greatherThan']}";
                        // $value3 = $options['greatherThan'];
                    }

                    if (!empty($options['orderBy'])) {
                        $sql .= " ORDER BY {$options['orderBy']}";
                    }

                    if (!empty($options['limit'])) {
                        $sql .= " LIMIT {$options['limit']}";

                        if (!empty($options['offset'])) {
                            $sql .= " OFFSET {$options['offset']}";
                        }
                    }

                    if (!$this->query($sql, $data)->error()) {
                        return $this;
                    }
                } else {
                    // For other operators, use the original logic
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                    if (!empty($options['orderBy'])) {
                        $sql .= " ORDER BY {$options['orderBy']}";
                    }

                    if (!empty($options['limit'])) {
                        $sql .= " LIMIT {$options['limit']}";

                        if (!empty($options['offset'])) {
                            $sql .= " OFFSET {$options['offset']}";
                        }
                    }

                    if (!$this->query($sql, array($value))->error()) {
                        return $this;
                    }
                }
            }
        }


        return false;
    }

    public function get($table, $where, $options = array())
    {
        return $this->action('SELECT *', $table, $where, $options);
    }

    public function delete($table, $where)
    {
        return $this->action('DELETE', $table, $where);
    }

    public function insert($table, $fields = array())
    {
        if (count($fields)) {
            $keys = array_keys($fields);
            $values = '';
            $x = 1;

            foreach ($fields as $field) {
                $values .= '?';

                if ($x < count($fields)) {
                    $values .= ', ';
                }

                $x++;
            }

            $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys) . "`) VALUES ({$values})";

            if (!$this->query($sql, $fields)->error()) {
                return true;
            }
        }

        return false;
    }

    public function update($table, $identifier, $fields)
    {
        $set = '';
        $x = 1;
        $result = null;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = ?";

            if ($x < count($fields)) {
                $set .= ', ';
            }

            $x++;
        }

        $_identifier = gettype($identifier) === 'array' ? array_keys($identifier)[0] : 'id';
        $_value = gettype($identifier) === 'array' ? array_values($identifier)[0] : $identifier;

        $sql = "UPDATE {$table} SET {$set} WHERE {$_identifier} = '{$_value}'";

        if (!$this->query($sql, $fields)->error()) {
            return true;
        }

        return false;
    }

    public function results()
    {
        return $this->_results;
    }

    public function first()
    {
        return $this->results()[0];
    }

    public function error()
    {
        return $this->_error;
    }


    public function count()
    {
        return $this->_count;
    }
}
