<?php
$base_directory = dirname(dirname(__FILE__));
include_once($base_directory."/connect.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */



$query_terms = "select term, story from Terms";
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query


while ($run_terms = mysql_fetch_assoc($list_terms)) {
	echo "term: ".$run_terms['term']."<br />";
	$query_pages = "select page_content, story, id from Pages";
	$list_pages = mysql_query($query_pages) or die(mysql_error());
	
		while ($run_pages = mysql_fetch_assoc($list_pages)) {
			// Get Rid of SPANS
			$changes = preg_replace(array('/style="(.*?)"/','/<span(.*?)>/', '/<\/span>/','/<font(.*?)>/', '/<\/font>/', '/<strong><\/strong>/', '/<p><\/p>/','/ class="Standard"/'),'', $run_pages['page_content']);

			if ($run_terms['story'] == $run_pages['story']) {
				//fix keyterm tag
				$term = $run_terms['term']." ";
				$regex = "/".$term."/i";
				$string = '<mark class="keyterm">'.$term."</mark>";
				$changes = preg_replace($regex, $string, $changes);
				
				//lowercase terms
				$term = ' <mark class="keyterm">'.$run_terms['term']." ";
				$regex = "/".$term."/i";
				$string = strtolower($term);
					
				$changes = preg_replace($regex, $string, $changes);
				
				// Capitalize first letter if at the beginning of a sentence
				$term = '\. <mark class="keyterm">'.$run_terms['term'].' ';
				$regex = "/".$term."/i";
				$ucterm = strtolower($run_terms['term']);
				$ucterm = ucfirst($ucterm);
				$string = '. <mark class="keyterm">'.$ucterm.' ';
				$changes = preg_replace($regex, $string, $changes);
				
				$term = '><mark class="keyterm">'.$run_terms['term'].' ';
				$regex = "/".$term."/i";
				$ucterm = strtolower($run_terms['term']);
				$ucterm = ucfirst($ucterm);
				$string = '><mark class="keyterm">'.$ucterm.' ';
				$changes = preg_replace($regex, $string, $changes);
				
				$term = '\? <mark class="keyterm">'.$run_terms['term'].' ';
				$regex = "/".$term."/i";
				$ucterm = strtolower($run_terms['term']);
				$ucterm = ucfirst($ucterm);
				$string = '\? <mark class="keyterm">'.$ucterm.' ';
				$changes = preg_replace($regex, $string, $changes);
				
				$term = '\! <mark class="keyterm">'.$run_terms['term'].' ';
				$regex = "/".$term."/i";
				$ucterm = strtolower($run_terms['term']);
				$ucterm = ucfirst($ucterm);
				$string = '\! <mark class="keyterm">'.$ucterm.' ';
				$changes = preg_replace($regex, $string, $changes);
				

			}
			$changes = mysql_real_escape_string($changes);

			$query_update = <<<EOF
				Update Pages set page_content="$changes" where id={$run_pages['id']};
EOF;
			//echo $query_update;
			$run_update = mysql_query($query_update) or die(mysql_error());
			
		
		}

}

?>