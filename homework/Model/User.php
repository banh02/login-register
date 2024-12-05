<?php

require_once './Model/BaseModel.php';

class User extends BaseModel
{
    public $tableName = "users";
    public $columns = ["username", "password"];

    public function getUser()
    {
        $sql = "SELECT * FROM $this->tableName WHERE username= :username";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['username' => $this->username]);
        $result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
        return $result;
    }
}

?>