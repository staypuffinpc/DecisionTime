<?php
//gets user information
$query_user = "Select * from Users where user_id='$user_id'"; //mysql query variable
$list_user = mysql_query($query_user) or die(mysql_error()); //execute query
$user = mysql_fetch_assoc($list_user);//gets info in array

//get current_page data JOIN Stories on Pages.story = Stories.story_name
$query_page = "SELECT * FROM Pages 
JOIN Stories on Pages.story = Stories.story_id
WHERE Pages.id=".$page_id.""; //mysql query variable
$list_page = mysql_query($query_page) or die(mysql_error()); //execute query
$page = mysql_fetch_assoc($list_page);//gets info in array
//end get current_page data

//gets all navigation buttons JOIN Pages ON Page_Relations.page = Pages.id 
$query_nav = "SELECT * FROM Page_Relations 
JOIN Pages on Page_Relations.page_child = Pages.id
WHERE page_parent = '".$page['id']."' ORDER BY page_order ASC"; //mysql query variable
$list_nav = mysql_query($query_nav) or die(mysql_error()); //execute query
//end get navigation buttons

//query to get progress
$progress_get = "Select * from User_Progress where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
$progress_get_list = mysql_query($progress_get) or die(mysql_error()); //execute query
$progress = mysql_fetch_assoc($progress_get_list);

// adds to progress stack
if ($progress['progress_page'] == NULL) {
/* $instructions = true; */
$query_progress_update = "insert into User_Progress (id,progress_user,progress_page, progress_story) values (null,'$user_id','$page_id','$story')"; //mysql query variable
$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
}
else {
$new_page = $progress['progress_page'].", ".$page_id;
$query_progress_update = "Update User_Progress set progress_page='$new_page' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
$instructions = false;
}

//adds to story stack
if ($page['page_type'] == "Story") {
	if ($progress['progress_story_pages'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_story_pages='$page_id' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_story_pages'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_story_pages='$new_page' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}

//adds to appendix stack
if ($page['page_type'] == "Appendix") {
	if ($progress['progress_appendix'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_appendix='$page_id' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_appendix'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_appendix='$new_page' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}

//adds to teaching stack
if ($page['page_type'] == "Teaching") {
	if ($progress['progress_teaching'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_teaching='$page_id' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_teaching'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_teaching='$new_page' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}

if ($page['finish_page'] == "true") {
	if ($progress['progress_finish'] == NULL) {
		$query_progress_update = "Update User_Progress Set progress_finish='$page_id' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
	else {
		$new_page = $progress['progress_finish'].", ".$page_id;
		$query_progress_update = "Update User_Progress set progress_finish='$new_page' where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
		$list_progress_update = mysql_query($query_progress_update) or die(mysql_error()); //execute query
	}
}


//look for summary
$progress_get = "Select * from User_Progress where progress_user='$user_id' and progress_story='$story'"; //mysql query variable
$progress_get_list = mysql_query($progress_get) or die(mysql_error()); //execute query
$progress = mysql_fetch_assoc($progress_get_list);
if (strlen($progress['progress_finish']) >0){$finish=true;}
	else {
	$temp = strpos($progress['progress_page'], $page['story_summary']);
	if ($temp === false) {$finish = false;}
		else {$finish = true;}
}



/* commented out on 9/8/2011 RemoveMeComments
$n = count($visited_pages)-1;

do {
	if ($visited_pages[$n]!==$page_id){
		$page_type_search = "Select * from Pages where id='$visited_pages[$n]'";
		$list_page_type = mysql_query($page_type_search) or die(mysql_error());
		$results = mysql_fetch_assoc($list_page_type);
			if($results['page_type'] == "Story" || $results['page_type'] == "Teaching") {$back_id=$visited_pages[$n];$back_name=$results['page_name'];break;}
			else {$n=$n-1;}
		}
	else {$n=$n-1;}
} while ($n>0);
*/

/* Find out how many questions have yet to be answered */
$query_worksheet = "Select id from User_Worksheet where user_id='$user_id' and story='$story'"; //mysql query variable
$list_worksheet = mysql_query($query_worksheet) or die(mysql_error()); //execute query
$worksheet = mysql_fetch_assoc($list_worksheet);//gets info in array
$worksheet_done = mysql_num_rows($list_worksheet); //gets number of links


$query_worksheet = "Select worksheet_id from Worksheet where worksheet_story='$story'";
$list_worksheet = mysql_query($query_worksheet) or die(mysql_error()); //execute query
$worksheet = mysql_fetch_assoc($list_worksheet);//gets info in array
$worksheet_count = mysql_num_rows($list_worksheet);

$visited_pages = explode(", ", $progress['progress_page']);

$worksheet_count = $worksheet_count - $worksheet_done;

if (in_array($page_id, $visited_pages)){$current_worksheet=0;}
else {
	$query_current_worksheet = "Select * from Worksheet where worksheet_page='$page_id'"; //mysql query variable
	$list_current_worksheet = mysql_query($query_current_worksheet) or die(mysql_error()); //execute query
	$current_worksheet = mysql_num_rows($list_current_worksheet); //gets number of links
}
/* Checks for author permissions */
$query="Select * from Author_Permissions where user_id = '$user_id' and story_id = '$story'";
$run = mysql_query($query) or die(mysql_error());
$results = mysql_fetch_assoc($run);

if ($results['id'] == NULL) {$author = false;} else {$author = true;}
if ($user['role'] == "Super User") {$author = true;}

$queryQuiz = "Select item_id from Quiz_Items where story_id = '$story'";
$runQuiz = mysql_query($queryQuiz) or die(mysql_error());
$quizCount = mysql_num_rows($runQuiz);
if ($quizCount > 0) {$quizAvailable = True;} else {$quizAvailable = False;}




?>