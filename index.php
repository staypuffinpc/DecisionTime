<?php
/* Depending on the url this provides absolute links to the files that are needed for every file. */
$base_directory = dirname(__FILE__);
include_once($base_directory."/connect.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */


if(!isset($_SESSION)){session_start();}

if(!isset($_SESSION['user_id']))
{
    //Destroy anything they have in their old session.
    session_destroy();
    //If they do not have an active session we redirect them to the login page
	
    echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=login.php'>";
	
    //Kill current page since the user needs to login first
    exit();
}
else{
	echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=dashboard/index.php'>";
}
$user_id = $_SESSION['user_id'];

//


?>