<div id="instructions-class-stories"> Instructions: Drag stories  to your Class list to add them to your class. Drag stories from your class list to remove them.</div>
	<ul id="all" class="connectedSortable"></ul>
	<ul id="class" class="connectedSortable"></ul>
<?php
	$query = "Select story_id, story_name from Stories";
	$run = mysql_query($query) or die(mysql_error());
	while ($results = mysql_fetch_assoc($run)) {
		$query = "Select * from Class_Stories where class_id='$class_id' and story_id = '".$results['story_id']."'";
		$check = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($check)<1) {
			$action = <<<EOF
			<script type='text/javascript'>
			$('#all').append("<li id='story[{$results['story_id']}]'>{$results['story_name']}</li>");
			</script>
EOF;
		}
		else {
			
			$action = <<<EOF
			<script type='text/javascript'>
			$('#class').append("<li id='story[{$results['story_id']}]'>{$results['story_name']}</li>");
			</script>
EOF;
		
		}
	echo $action;
	
	}
?>		
	