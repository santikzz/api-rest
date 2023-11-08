<?php

require_once "./database/database.php";

class UserModel{

    private $db;

    public function __construct(){
        $this->db = db_connect();  
    }

    public function getUser($username){
        $stmt = $this->db->prepare("SELECT id, username, password, isAdmin FROM usuario WHERE username = :parameter");
        $stmt->execute(["parameter" => $username]);
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

}

