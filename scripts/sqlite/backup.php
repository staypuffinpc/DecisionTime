<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */


$table_query = "SHOW TABLES FROM project301"; //query to get list of tables

$list_of_tables = mysql_query($table_query); //execute query to get list of tables


/* Create Sqlite Database */
$sqlite_db = New sqlite3("db.db");

/* traverse list of tables and get fields */
while ($row = mysql_fetch_row($list_of_tables)) {
    	$fields_to_create = "("; //begin of create statement to make table is sqlite db
		$fields_to_insert = "("; //beginning of values to be inserted statement.
		$fields_query = "Show Columns from {$row[0]}"; // query to get list of columns or fields.
		$run_fields_query = mysql_query($fields_query) or die(mysql_error()); // executes query
		while ($field_results = mysql_fetch_assoc($run_fields_query)) { //gets all the fields
			$fields_to_create = $fields_to_create.$field_results['Field'].", "; // updates the list of fields to create
			$fields_to_insert = $fields_to_insert."\$results[\"{$field_results['Field']}\"], ";
		}
		$fields_to_create = substr($fields_to_create, 0, -2); //removes space and comma from the end of the string
		$fields_to_create = $fields_to_create.")"; // adds closing parentheses to creation script
		$fields_to_insert = substr($fields_to_insert, 0, -2); //removes space and comma from the end of the string
		$fields_to_insert = $fields_to_insert.")";

		/* Sqlite create table */
		$sqlite_db->exec("CREATE TABLE {$row[0]} $fields_to_create"); //creates table in sqlite db
		
		$query = "Select * from {$row[0]}"; // query to get data from table
		$run = mysql_query($query) or die(mysql_error()); //runs previous query
		$fields_to_insert = stripslashes($fields_to_insert);

		while ($results = mysql_fetch_assoc($run)) { //loop to insert all data
			$data = <<<EOF
				INSERT INTO {$row[0]} $fields_to_create VALUES $fields_to_insert
EOF;
			echo $data."<br />";
			$sqlite_db->prepare($data);
			

			$sqlite_db->exec($data);
		}
}



?>