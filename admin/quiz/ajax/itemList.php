<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];

$query = "Select  * from Quiz_Items where story_id='$story'";
$run = mysql_query($query) or die(mysql_error());

$query = "Select page_name, id from Pages where story='$story' and page_type='Teaching'";
$run2 = mysql_query($query) or die(mysql_error());


while ($items = mysql_fetch_assoc($run)) {
	echo <<<EOF
	<li id="{$items['item_id']}">
	<div class="delete {$items['item_id']}" title="Click to delete this item">x</div>
	<p>Question Prompt ({$items['item_type']})</p>
	<div class="ce item_prompt {$items['item_id']}">{$items['item_prompt']}</div>
	<p>Responses <a class='btn {$items['item_id']} newResponse'>Add a new response</a></p>
	<div class="responseSection">	

EOF;

	$query = "Select * from Quiz_Responses where item_id='".$items['item_id']."'";
	$responses = mysql_query($query) or die(mysql_error());
	while ($response = mysql_fetch_assoc($responses)) {
	if ($items['item_type'] == "Multiple Choice") {
	echo <<<EOF
	<div class="deleteResponse {$response['id']}" title="Click to delete this response.">x</div><input type="radio" name="{$items['item_id']}" value="{$response['id']}" 
EOF;
	if ($items['item_answer'] == $response['id']) {echo " checked ";}	

	echo <<<EOF
	/> <div class="ce item_response {$response['id']}">{$response['item_response']}</div><br />
EOF;
	} //end multiple choice if
	if ($items['item_type'] == "Fill in the Blank"){
	echo <<<EOF
		<div class="ce item_response {$response['id']}">{$response['item_response']}</div><br />
EOF;
	} // end fill in the blank item type
	} //end response while
	

	echo <<<EOF
	</div>
	<div style="float:left;display:block-inline;width: 70%">
	<p>Answer Explanation</p>
	<div class="ce item_explanation {$items['item_id']}">{$items['item_explanation']}</div></div>	
EOF;
	echo <<<EOF
	<div style="float:left">
	<p>Related Pages</p>
	<select id='pages' name='pages[]' multiple='multiple' class="select item_pages {$items['item_id']}">
EOF;
	mysql_data_seek($run2, 0);
	while ($results = mysql_fetch_assoc($run2)) {
		echo "<option value='{$results['id']}'";
		$temp = strpos($items['item_pages'], $results['id']);
		if ($temp === false) {} else {echo " selected";}
		echo ">{$results['page_name']}</option>";
	
	
	}
	echo "</select></div><div style='float:none;clear: both'></div></li>";
	
}

?>