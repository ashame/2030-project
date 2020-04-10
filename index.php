<?php session_start(); 

require 'database/config.php';

if (!isset($_SESSION['user'])) {

    include 'templates/login.php';

} else {

    include 'templates/main.php';

}

?>