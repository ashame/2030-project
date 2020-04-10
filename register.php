<?php session_start();
    include 'database/database.php';

    $pdo = db_connect();
    
    include 'templates/register.php';
?>