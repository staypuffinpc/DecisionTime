<?php

$base_directory = dirname(dirname(__FILE__));
echo $base_directory;
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database


$user_id = $_SESSION['user_id'];
include_once('dashboard.php');

?>