<?php

namespace app\core;

use app\core\utils\DateHelper;


class Model
{
    private $_db;
    private $_table;

    public function __construct($table = null)
    {
        if ($table) {
            $this->_table = $table;
        }

        $this->_db = \app\core\Database::getInstance();
    }

    public function create($fields = array())
    {
        $fieldsToCreate = array(
            ...$fields,
            // 'created_at' => DateHelper::getCurrentDate()
        );

        if (!$this->_db->insert($this->_table, $fieldsToCreate)) {
            return false;
        }

        return true;
    }

    public function updateOne($identifier, $field)
    {
        $fieldsToUpdate = array(
            ...$field,
            'updated_at' => DateHelper::getCurrentDate()
        );

        $result = $this->_db->update($this->_table, $identifier, $fieldsToUpdate);

        if (!$result) {
            return false;
        }

        return true;
    }

    protected function update($id, $fields)
    {
        $fieldsToUpdate = array(
            ...$fields,
            'updated_at' => DateHelper::getCurrentDate()
        );
        if (!$this->_db->update($this->_table, $id, $fieldsToUpdate)) {
            return false;
        }

        return true;
    }

    public function selectOneById($id)
    {
        if ($id) {
            $data = $this->_db->get($this->_table, array('id', '=', $id));

            if ($data->count()) {
                return $data->first();
            }
        }

        return false;
    }

    public function selectOne($identifier, $value)
    {
        if ($identifier && $value) {
            $data = $this->_db->get($this->_table, array($identifier, '=', $value));

            if ($data->count()) {
                return $data->first();
            }
        }

        return false;
    }
    public function select($identifier, $value, $options = array())
    {
        $data = $this->_db->get($this->_table, array($identifier, '=', $value), $options);

        if ($data->count()) {
            return $data;
        }

        return false;
    }
    public function selectByNotEqual($identifier, $value, $options = array())
    {
        $data = $this->_db->get($this->_table, array($identifier, '!=', $value), $options);

        if ($data->count()) {
            return $data;
        }

        return false;
    }

    public function selectByGreaterThan($identifier, $value, $options = array())
    {
        $data = $this->_db->get($this->_table, array($identifier, '>', $value), $options);

        if ($data->count()) {
            return $data;
        }

        return false;
    }
}
