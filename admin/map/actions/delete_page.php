<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');
$user_id=$_SESSION['user_id'];
$page_id = $_GET['page_id'];

$query = "DELETE from Pages where id='$page_id'";
$list = mysql_query($query) or die(mysql_error()); //execute query

$queryD = "Select * from Page_Relations where page_child='$page_id' OR page_parent='$page_id'";
$listD = mysql_query($queryD) or die(mysql_error()); //execute query
$D = mysql_fetch_assoc($listD);//gets info in array


$query1 = "DELETE from Page_Relations where page_child='$page_id' OR page_parent='$page_id'";
$list1 = mysql_query($query1) or die(mysql_error()); //execute query


?>
page deleted <br />
<?php
do {
?>
<script>

$("#line<?php echo $D['page_relation_id']; ?>").fadeOut();

</script>
<?php




} while ($D = mysql_fetch_assoc($listD));
?>