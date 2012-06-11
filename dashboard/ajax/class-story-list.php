<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$class_id = $_POST['id'];

$query = "Select * From Class_Stories JOIN Stories on Stories.story_id = Class_Stories.story_id JOIN Users on Stories.story_creator = Users.user_id where Class_Stories.class_id = '$class_id'";
$list_stories = mysql_query($query) or die(mysql_error()); //execute query


?>
<div class="story">
<a class='dbutton' id="showAll">Show all Stories</a>

</div>

<?php

$class = array();
$query = "Select * from Class_Stories join Class_Members on Class_Stories.class_id = Class_Members.class_id where Class_Members.user_id = '$user_id'";
	$run = mysql_query($query) or die(mysql_error());
	while ($result = mysql_fetch_assoc($run)) {
		$class[] = $result['story_id'];
	}

while ($stories = mysql_fetch_assoc($list_stories)) { 
	$query = "Select * from Author_Permissions where user_id=$user_id and story_id=".$stories['story_id']; //mysql query variable
	$list_query = mysql_query($query) or die(mysql_error()); //execute query
	$results = mysql_fetch_assoc($list_query);//gets info in array

	if ($stories['story_privacy'] == "Public" || $stories['story_creator'] == $user_id || $role == "Admin" || $results['id'] || in_array($stories['story_id'], $class)) {
		

?> 
	
	<div class="story">
	<a class="choice story" href="../story/index.php?page_id=<?php echo $stories['story_first_page'];?>&story=<?php echo $stories['story_id']; ?>">
		<?php 
		$query = "Select * from Author_Permissions where user_id=$user_id and story_id=".$stories['story_id']; //mysql query variable
			$list_query = mysql_query($query) or die(mysql_error()); //execute query
			$results = mysql_fetch_assoc($list_query);//gets info in array
		
		?><img class="book" src="../img/books.png" />
		<?php
		
		echo "<h5>".$stories['story_name']."</h5>"; 
		echo "<h6>by ".$stories['user_name']."</h6>"; 
		
		
		
		
		?>
		
	</a>
	
	<?php
		if ($role == "Admin" || $results['id']) {echo "<a href='../admin/index.php?story=".$stories['story_id']."' class='editLink'><img src='../img/edit.png' /></a>"; }
		if ($role == "Admin" || $stories['story_creator'] == $user_id) {echo "<a class='deleteLink' onclick='delete_story(".$stories['story_id'].");'><img src='../img/delete.png' /></a>";}
	?> </div> <?php
	}
}
 

 
 
 ?>