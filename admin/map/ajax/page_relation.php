<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
include_once('../../db.php');

$page_relation_id  = $_POST['relation_id'];

$query_id = "Select * from Page_Relations where page_relation_id='$page_relation_id'"; //mysql query variable
$list_id = mysql_query($query_id) or die(mysql_error()); //execute query
$id = mysql_fetch_assoc($list_id);//gets info in array


?>


<h2>Link Editor</h2>
<form>
<input type="hidden" name="page_relation_id" id="page_relation_id" value="<?php echo $page_relation_id; ?>"/>
<input size="40" type="text" name="page_stem" id="page_stem" value="<?php echo $id['page_stem']; ?>" />
<input size="40" type="text" name="page_link" id="page_link" value="<?php echo $id['page_link']; ?>" />
<input size="1" type="text" name="page_punctuation" id="page_punctuation" value="<?php echo $id['page_punctuation']; ?>" />


</form>
<br />
<a class="btn" id="update_relation" onClick="update_relation();">Update Link</a>
<a class="btn" id="delete_relation" onClick="delete_relation();">Delete Link</a>