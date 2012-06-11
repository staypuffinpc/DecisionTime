<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story_id = $_SESSION['story'];

$query = "Select * from Pages where story='$story_id' and page_type='Teaching' order by print_order ASC";
$run = mysql_query($query) or die(mysql_error());

while ($results = mysql_fetch_assoc($run)) {
echo "<div class='page-name'>".$results['page_name']."</div>";

$content = str_replace("/isee/images/", "http://ipt.byu.edu/isee/images/", $results['page_content']);

echo $content;
	
echo "<div class='page-break'> </div>";
}
echo "<h2>References</h2>";
mysql_data_seek($run, 0);
while ($results = mysql_fetch_assoc($run)) {
echo $results['page_references'];
}

$query_terms = "Select * from Terms Where story='$story' ORDER BY term ASC"; //mysql query variable
$list_terms = mysql_query($query_terms) or die(mysql_error()); //execute query
$terms = mysql_fetch_assoc($list_terms);//gets info in array
?>
<h2>Glossary</h2>
<table class="glossary">
<?php
do { ?>
	<tr>
	<td class="term"><?php echo $terms['term']; ?></td>
	<td><?php echo $terms['definition']; ?></td>
	
	</tr>


<?php } while ($terms = mysql_fetch_assoc($list_terms));


?>
</table>
