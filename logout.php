<?php // logout.php 
session_start(); 
 
// you may want to delete the session cookie 
if (isset($_COOKIE[session_name()])) { 
  
} 
session_destroy(); 
echo 'You have been logged out.'; 
echo  "<meta HTTP-EQUIV='REFRESH' content='0; url=login.php'>";

?>