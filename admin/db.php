<?php
$query_story = "Select * from Stories Join Users on Users.user_id = Stories.story_creator where story_id=$story "; //mysql query variable
$list_story = mysql_query($query_story) or die(mysql_error()); //execute query
$story_info = mysql_fetch_assoc($list_story);//gets info in array

$query_pages = "Select * from Pages where story=$story AND page_top is not null ORDER by page_name ASC"; //mysql query variable
$list_pages = mysql_query($query_pages) or die(mysql_error()); //execute query

$query_new_pages = "Select * from Pages where story=$story AND page_top is null ORDER by page_name ASC"; //mysql query variable
$list_new_pages = mysql_query($query_new_pages) or die(mysql_error()); //execute query
$new_pages = mysql_fetch_assoc($list_new_pages);//gets info in array

$query_page_relations = "Select * from Page_Relations where page_story=$story"; //mysql query variable
$list_page_relations = mysql_query($query_page_relations) or die(mysql_error()); //execute query
?>