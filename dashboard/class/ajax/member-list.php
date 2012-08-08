<?
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];

/*
$query_members = "select 
	u.user_name,
	u.user_id,
	u.user_email,
	u.user_image,
	cm.class_id,
	cm.user_id
from 
	Users u,
	Class_Members cm
where
 	cm.class_id = ".$class_id."
order by
	u.user_name"; //mysql query variable
*/
$class_id = $_SESSION['class_id'];
$query_members = "select * from Class_Members join Users on Class_Members.user_id = Users.user_id where class_id = $class_id";
$list_members = mysql_query($query_members) or die(mysql_error()); //execute query

?>
<div id="add-member-area"><a class="btn" id="add-member">Manually Add Student</a></div>
<div id="tabular-data-table">
<table cellpadding="5px" id="tabular-data">
	<tr>
		<td></td>
		<td class="header">Name</td>
		<td class="header">Email</td>
		<td></td>
	</tr>
	<?
/* 	$results = mysql_fetch_assoc($run); */
	while ($members = mysql_fetch_assoc($list_members)) {
		?>
		<tr>
			<td><img width="14px" src="../<? echo $members["user_image"]; ?>" /></td>
			<td><a class="user-edit" id="user-<? echo $members['user_id']; ?>"><? echo $members["user_name"]; ?></a></td>
			<td><? echo $members["user_email"]; ?></td>
			<td><a class="delete-user" id="<? echo $members['user_id'];?>">Remove user?</a></td>
		</tr>
		<?
	}
	?>
</table>
</div>
<script>
	$("tr:odd").css("background-color", "#CCCCCC");
</script>