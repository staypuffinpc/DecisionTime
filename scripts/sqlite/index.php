<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */


$table_query = "SHOW TABLES FROM project301"; //query to get list of tables

$list_of_tables = mysql_query($table_query); //execute query to get list of tables


/* Create Sqlite Database */
$sqlite_db = New sqlite3("db.db");

/* traverse list of tables and get fields */
while ($row = mysql_fetch_row($list_of_tables)) {
    	$fields_to_create = "("; //begin of create statement to make table is sqlite db
		$fields_query = "Show Columns from {$row[0]}"; // query to get list of columns or fields.
		$run_fields_query = mysql_query($fields_query) or die(mysql_error()); // executes query
		while ($field_results = mysql_fetch_assoc($run_fields_query)) { //gets all the fields
			$fields_to_create = $fields_to_create.$field_results['Field'].", "; // updates the list of fields to create
		}

		$fields_to_create = substr($fields_to_create, 0, -2).")"; //removes space and comma from the end of the string


		/* Sqlite create table */
		$sqlite_db->exec("CREATE TABLE {$row[0]} $fields_to_create"); //creates table in sqlite db
		
		$query = "Select * from {$row[0]}"; // query to get data from table
		$run = mysql_query($query) or die(mysql_error()); //runs previous query

		while ($results = mysql_fetch_assoc($run)) { //loop to insert all data
			$i = 0; //counter for getting info for insert query
			$fields = "("; //start field list for query
			$fieldValueList = "("; //start field value list for query
			foreach ($results as $fieldValue) { // loop to create field and value lists
				$fieldName = mysql_field_name($run,$i); //get field name
				$i = $i + 1; //increment counter
				$fields = $fields.$fieldName.", "; //make list of field names
				$fieldValue = preg_replace("/'/","&apos;", $fieldValue);

				
				$fieldValueList = $fieldValueList."'".$fieldValue."', "; //make list of field values
				
			}  
			$fields = substr($fields, 0, -2).")"; // remove trailing comma and space and add end parenthesis
			$fieldValueList = substr($fieldValueList, 0, -2).")"; // remove trailing comma and space and add end parenthesis
		
			// SQLite Query
			$data = <<<EOF
				INSERT INTO {$row[0]} $fields VALUES $fieldValueList
EOF;
/* 			echo $data."<br />"; */
/* 			sqlite_escape_string($data); */
			$sqlite_db->prepare($data); //prepare sqlite query
			

			$sqlite_db->exec($data); //execute query
		} //end table creation
} // end insertion



?>