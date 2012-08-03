<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];
$query = "Select * from Worksheet where worksheet_story='$story' order by worksheet_order ASC";
$run = mysql_query($query) or die(mysql_error());

$query = "Select page_name, id from Pages where story='$story' and page_type='Teaching'";
$pages = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {
		if (strlen($results['worksheet_text']) > 88) {
			$text = substr($results['worksheet_text'], 0, 87)." . . .";
		} else $text = $results['worksheet_text'];
		echo <<<EOF
			<li id='item[{$results['worksheet_id']}]' class='ui-state-default'>
			<div class='number'>{$results['worksheet_order']}. </div><div class='type'>{$results['worksheet_type']}</div><div class="embeddedNote" 
EOF;
		if($results['embedded'] == 1) {echo "style='padding:1px'>embedded";} else {echo ">";}
		echo <<<EOF
		</div><div class="textShort"> - $text</div>
		<div class="item-info"><div class="label">Text: </div><div class="ce text {$results['worksheet_id']}" contenteditable>{$results['worksheet_text']}</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Response: </div><br />		
EOF;

		switch ($results['worksheet_type']) {
			case "Short Answer":
				echo "<div><textarea disabled='disabled' ></textarea></div>";
				break;
			case "Fill in the Blank":
				echo "<div><input type='text' disabled='disabled' /></div>";
				break;
			case "True or False":
				echo "<div><input type='radio' disabled='disabled'>True<br>
				<input type='radio' disabled='disabled'>False<br></div>";
				break;
			case "Multiple Choice":
				echo "<div class='theresponse {$results['worksheet_id']}'>";
				echo $results['worksheet_response'];
				echo "</div><script>$('.response').attr('contenteditable', true);</script>";		
		}
		
		
		
		
		echo "<div class='spaceTaker'></div>";

		if ($results['worksheet_type'] == "Multiple Choice") { echo "<div class='addItem ".$results['worksheet_id']."'>Add Item</div><div class='removeItem ".$results['worksheet_id']."'>Remove Item</div>";}
		echo <<<EOF
		<div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Answer: </div><br /><div class="ce answer {$results['worksheet_id']}" contenteditable>{$results['worksheet_answer']}</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Page: </div><select class="{$results['worksheet_id']}"><option>None Selected</option>
EOF;
		while ($resultsPages = mysql_fetch_array($pages)) {
			echo "<option value='".$resultsPages['id']."'";
		if ($resultsPages['id'] == $results['worksheet_page']) {echo " selected ";}
		echo ">".$resultsPages['page_name']."</option>";
		}
		echo "</select></div>";
		echo <<<EOF
		<div class="item-info"><div class="label">Embedded: </div><div class='embeddedContainer'>
		<input class='{$results['worksheet_id']}' type='checkbox'
EOF;
		if ($results['embedded'] == 1) {echo " checked ";}
		echo "/></div></div>";		
		echo <<<EOF
			<div title='Remove this item' class='delete' id='delete{$results['worksheet_id']}'>x</div></li>
EOF;
			
		mysql_data_seek($pages, 0);	
} 
?>
