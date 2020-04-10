<?php
require 'config.php';

function db_connect() {
    $host = DBHOST;
    $db = DBNAME;
    $user = DBUSER;
    $pass = DBPASS;
  
    $conn = "mysql:host=$host;dbname=$db";
  
    try {
      return new PDO($conn, $user, $pass);
    }
    catch (PDOException $e)
    {
      die($e->getMessage());
    }
}
