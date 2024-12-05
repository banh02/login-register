<?php

class BaseModel
{
    public $connection;
    private $host = "localhost";
    private $dbname = "home_work";
    private $usernameDB = "root";
    private $passwordDB = "";

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->usernameDB, $this->passwordDB);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function insert()
    {
        $this->queryBuilder = "INSERT INTO $this->tableName (";
        foreach ($this->columns as $col) {
            if ($this->{$col} == null && !is_string($this->{$col})) {
                continue;
            }
            $this->queryBuilder .= "$col, ";
        }
        $this->queryBuilder = trim($this->queryBuilder, ", ");
        $this->queryBuilder .= ") VALUES ( ";
        foreach ($this->columns as $col) {
            if ($this->{$col} == null)
                continue;
            $this->queryBuilder .= "'" . $this->{$col} . "', ";
        }
        $this->queryBuilder = trim($this->queryBuilder, ", ");
        $this->queryBuilder .= ")";

        $stmt = $this->connection->prepare($this->queryBuilder);
        try {

            $stmt->execute();
            $this->id = $this->connection->lastInsertId();

            return $this;
        } catch (Exception $ex) {
            return null;
        }
    }
}