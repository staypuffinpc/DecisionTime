<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$child=$_POST['child'];
$parent = $_POST['parent'];

if (isset($_POST['page_stem'])){
$page_stem = $_POST['page_stem'];
$page_link = $_POST['page_link'];
$page_punctuation = $_POST['page_punctuation'];

}
echo "Loaded.<br />";
if ($parent !== $child) {

$query = "Select page_name from Pages where id='$child'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);
$child_name = $results['page_name'];

if (isset($_POST['page_stem'])){
$query="Insert into Page_Relations (page_relation_id, page_child, page_parent, page_story, page_stem, page_link, page_punctuation, page_external) Values (NULL, '$child','$parent','$story','$page_stem','$page_link','$page_punctuation', 'true')";
}
else {
$query="Insert into Page_Relations (page_relation_id, page_child, page_parent, page_story, page_stem, page_link, page_punctuation, page_external) Values (NULL, '$child','$parent','$story','Go to','$child_name','.','false')";
}
$list_query = mysql_query($query) or die(mysql_error()); //execute query
$lastItemID = mysql_insert_id();
$magL = $_SESSION['magL'];
$magT = $_SESSION['magT'];



$query_newrelation = "Select * from Page_Relations where page_relation_id='$lastItemID'"; //mysql query variable
$list_newrelation = mysql_query($query_newrelation) or die(mysql_error()); //execute query
$newrelation = mysql_fetch_assoc($list_newrelation);//gets info in array
if (!isset($_POST['page_stem'])){
$line = "<div class='line' id='line".$newrelation['page_relation_id']."'><div title='".$newrelation['page_stem']." ".$newrelation['page_link'].$newrelation['page_punctuation']."' id='arrow".$newrelation['page_relation_id']."' class='arrow'></div></div>";
$line_draw = $newrelation['page_parent'].", ".$newrelation['page_child'].", ".$newrelation['page_relation_id'].",".$magT.", ".$magL;


?>

<P>Relation added</P>
<script>
$("#mainbody").append("<?php echo $line; ?>");
line(<?php echo $line_draw ?>);

</script>

<?php } } 
else {echo "<p>Not Added</p>";}




?>