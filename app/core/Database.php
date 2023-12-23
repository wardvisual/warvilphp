<?php

namespace app\core;

class Database
{
    private $_pdo,
        $_query,
        $_error = false,
        $_results,
        $_count = 0;

    private $_host;
    private $_dbname;
    private $_username;
    private $_password;
    private $_charset;


    protected function __construct()
    {
        $this->_host = Config::get('database/host');
        $this->_dbname = Config::get('database/dbname');
        $this->_username = Config::get('database/username');
        $this->_password =  Config::get('database/password');
        $this->_charset = 'utf8mb4';
        $dsn = "mysql:host={$this->_host};dbname={$this->_dbname};charset={$this->_charset}";

        try {
            $this->_pdo = new \PDO($dsn, $this->_username, $this->_password);

            $this->_pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            $this->_error = true;
            die("Connection failed: " . $e->getMessage());
        }
    }

    protected function query($sql)
    {
        $this->_query = $this->_pdo->prepare($sql);
    }

    protected function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        $this->_query->bindValue($param, $value, $type);
    }

    protected function execute()
    {
        if (!$this->_query->execute()) {
            $this->_error = true;
        }

        return $this;
    }

    protected function resultSet()
    {
        $this->execute();
        return $this->_query->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function single()
    {
        $this->execute();
        return $this->_query->fetch(\PDO::FETCH_ASSOC);
    }

    protected function rowCount()
    {
        return $this->_query->rowCount();
    }

    protected function hasError()
    {
        return $this->_error;
    }

    protected function lastInsertId()
    {
        return $this->_pdo->lastInsertId();
    }

    protected function beginTransaction()
    {
        return $this->_pdo->beginTransaction();
    }

    protected function endTransaction()
    {
        return $this->_pdo->commit();
    }

    protected function cancelTransaction()
    {
        return $this->_pdo->rollBack();
    }

    protected function debugDumpParams()
    {
        return $this->_query->debugDumpParams();
    }
}