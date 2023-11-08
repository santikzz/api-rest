<?php

function db_connect(){
    
    $db_host = "localhost";
    $db_name = "tudai";
    $db_user = "root";
    $db_pass = "";
    
    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    // $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $db;

}


?>