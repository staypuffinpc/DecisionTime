<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_SESSION['story'];

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query

$query = "Select page_content, id, page_name from Pages where story='$story'";
$run = mysql_query($query) or die(mysql_error());

if (isset($_GET['term'])) {$new_term = $_GET['term'];}


?>


<h2>Glossary</h2>
<table class="glossary">
<?php
while ($terms = mysql_fetch_assoc($list_terms)) { ?>
	<tr class="clickable-item" id="<?php echo $terms['term_id']; ?>">
	<td><img class="deleteTerm <?php echo $terms['term_id']; ?>" src="../../img/minus.png" /></td>
	<td class='term'><span class="<?php echo $terms['term_id']; ?>"><?php echo $terms['term']; ?></span></td>
	<td><span class="<?php echo $terms['term_id'];?>D"><?php echo $terms['definition']; ?></span><div class='page-list'><span class="page-list-count" id="<?php echo $terms['term_id']; ?>P"></span>
	<?php
	$counter = 0;
	mysql_data_seek($run, 0);
	while ($results = mysql_fetch_assoc($run)) {
				$pos = stripos($results['page_content'], $terms['term']);
		if ($pos === false) {}
		else {
			echo "<a href='index.php?page_id={$results['id']}'>{$results['page_name']}</a> ";
			$counter++;	
		}
		
	} 
	if ($counter == 1) {echo "<script> document.getElementById('{$terms['term_id']}P').innerHTML = 'Page: ';</script>";}
	if ($counter > 1) {echo "<script> document.getElementById('{$terms['term_id']}P').innerHTML = 'Pages: ';</script>";}

	?></div></td></tr>
<?php } ?>
</table>
<div id="term-editor">Click on a row to edit the content.</div>
<script>
<?php if (isset($new_term)) {echo "openInTermEditor($new_term);";} ?>
formatGlossary();
markRed();
</script>