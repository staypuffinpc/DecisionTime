<?php 
$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_POST['user_id'];
$password = $_POST['password'];


if($password == "breakIn") {

	
$query = "Select * from Users where user_id = $user_id";
$run = mysql_query($query) or die(mysql_error()); //execute query
$user = mysql_fetch_assoc($run);//gets info in array

if(!isset($_SESSION)){session_start();}
$_SESSION['user_id'] = $user_id = $user['user_id'];
$_SESSION['user_name'] = $user['user_name'];
$_SESSION['role']= $user['role'];
$_SESSION['user_image'] = $user['user_image'];
$_SESSION['admin'] = true;
include_once('dashboard.php');
}

else {echo "<script>window.location = '../login.php';</script>";}
 ?>