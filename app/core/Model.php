<?php 

namespace app\core;

class Model {
    protected $db;

    public function __construct()
    {
        // $this->db = new Database();
    }

    // insert
    public function insert($table, $data)
    {
        $fields = implode(', ', array_keys($data));
        $values = implode(', ', array_map(function($value) {
            return "'" . $value . "'";
        }, array_values($data)));

        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
        $this->db->query($sql);
        $this->db->execute();
        return $this->db->rowCount();
    }
}