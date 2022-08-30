<?php

class Transaction extends Database
{
    private $db;

    public function __construct(){
        $this->db = parent::getInstance();
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->db->beginTransaction();
    }

    public function commit()
    {
        return $this->db->commit();
    }
    
    public function rollBack()
    {
        return $this->db->rollBack();
    }
}