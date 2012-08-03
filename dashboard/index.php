<?php

$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database


$user_id = $_SESSION['user_id'];
include_once('dashboard.php');

?>