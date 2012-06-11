<?php 
	function connect() {
		$user="root";
		$host="127.0.0.1";
		$password="";
		$database="dt1";
		mysql_connect($host,$user,$password);
		$link = mysql_connect($host,$user,$password)
       		 or die("Could not connect" . mysql_error());
		mysql_select_db($database);
		return $link;
	}
?>