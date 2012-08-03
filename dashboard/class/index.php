<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
if (isset($_GET['class_id']))
	{
		$class_id = $_GET['class_id'];
		$_SESSION['class_id'] = $class_id;
	}
else {
	$class_id = $_SESSION['class_id'];
}

$query = "Select * from Classes where class_id = '$class_id'";
$run = mysql_query($query) or die(mysql_error());
$class = mysql_fetch_assoc($run);

/*
$query = "Select * from Class_Stories JOIN Stories on Stories.story_id = Class_Stories.story_id JOIN Users on Stories.story_creator = Users.user_id where class_id = '$class_id'";
$run = mysql_query($query) or die(mysql_error());

$query = "Select * from Class_Members Join Users on Class_Members.user_id = Users.user_id where class_id = '$class_id'";
$members = mysql_query($query) or die(mysql_error());
*/


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0, maximum-scale=1.0, user-scalable=0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>Class Management : <?php echo $class['class_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="class.css" rel="stylesheet" type="text/css" />
<link href="worksheet-data.css" rel="stylesheet" type="text/css" />
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>	


<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>
<script type="text/javascript" src="class.js"></script>
</head>

<body>
<script type="text/javascript">
var class_id = <?php echo $class_id; ?>;


</script>
<div id="header">Class Management : <?php echo $class['class_name']; ?>
<a id="home" class="upperLeft" href='../index.php'></a>

<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> <span class='name'> ".$_SESSION['user_name']."</span>"."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>
</div><!--  end header div -->
<div id="viewport">
	<div class="content" id="page1">
	<div id="code-info">Enrollment Code: <input type="text" id="enroll-code" value="<?php echo $class['enroll_code']; ?>" /><a class="btn" id="save-new-code">Save New Enrollment Code</a><span id="saved"></span></div>	
	<div id="manage-window">
		<div class="management-window" id="story-manager-info">
			<?
			include("ajax/story-list.php");
			?>
		</div>
		
		<div class="management-window" id="user-data-window-info">
			<? 
			include("ajax/user-data-window.php");
			?>
		</div>
		<div class="management-window" id="member-list-info">
		<?
		include("ajax/member-list.php");
		?>
		</div>
	</div>
		

	
	
	</div>
	<div class="content" id="page2">
	<table>
		<tr>
			<td>Name</td>
			<?php 
			while ($stories = mysql_fetch_assoc($run)) {
				echo "<td>".$stories['story_name']."<td>";
			}
			?>
			<td>Email</td>
		</tr>
	
	</table>
	
	<?php
	
	while ($results = mysql_fetch_assoc($members)) {
		echo $results['user_name']."<br /";
	
	
	}
	
	
	?>
	
	</div>

</div>
<div id="footer">
	<ul>
	<li id="story-manager">Story List</li>
	<li id="member-list">Students</li>
	<li id="user-data-window">User Data</li>
	</ul>

</div>
<div id="ajax">Processing<img src="../../img/ajax-loader.gif" /></div>
	<div id="fadebackground"></div>
	<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

