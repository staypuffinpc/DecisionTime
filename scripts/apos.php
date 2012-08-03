<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */



	$query_pages = "select page_content, story, id from Pages";
	$list_pages = mysql_query($query_pages) or die(mysql_error());
	
		while ($run_pages = mysql_fetch_assoc($list_pages)) {
			// Get Rid of SPANS
			$changes = preg_replace("/'/","&apos;", $run_pages['page_content']);

			$changes = mysql_real_escape_string($changes);

/* 			echo $changes."<br /><br />"; */
			
			$query_update = <<<EOF
				Update Pages set page_content="$changes" where id={$run_pages['id']};
EOF;
			//echo $query_update;
			$run_update = mysql_query($query_update) or die(mysql_error());
			
		
		}
	


?>