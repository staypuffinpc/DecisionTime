<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query

$query = "Select progress_page from User_Progress where progress_user ='$user_id' and progress_story='$story'";
$run = mysql_query($query) or die(mysql_error());
$progress = mysql_fetch_assoc($run);

$query = "Select page_content, id, page_name from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());



?>
<div class="page2-wrapper">
<h2>Glossary</h2>
<table class="glossary">
<?php
while ($terms = mysql_fetch_assoc($list_terms)) { ?>
	<tr>
	<td class='term'><?php echo $terms['term']; ?></td>
	<td><?php echo $terms['definition']; ?><div class='page-list'><span class="page-list-count" id="<?php echo $terms['term_id']; ?>"></span>
	<?php
	$counter = 0;
	mysql_data_seek($run, 0);
	while ($results = mysql_fetch_assoc($run)) {
		$p = strpos($progress['progress_page'], $results['id']);
		if ($p === false) {}
		else {
		$pos = stripos($results['page_content'], $terms['term']);
		if ($pos === false) {}
		else {
			echo "<a href='index.php?page_id={$results['id']}'>{$results['page_name']}</a> ";
			$counter++;	
		}
		}	
	} 
	if ($counter == 1) {echo "<script>$('span#{$terms['term_id']}').text('Page: ');</script>";}
	if ($counter > 1) {echo "<script>$('span#{$terms['term_id']}').text('Pages: ');</script>";}

	?></div></td></tr>
<?php } ?>
</table>
</div>
<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>
<p>The glossary contains a list of all of the key terms from throughout the story.  On instructional pages, key terms are the bolded words with a dotted underline.  You can click on that term for a quick definition.</p>
</div>

<script>
google_analytics();
formatGlossary();
</script>