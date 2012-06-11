<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$class_id = $_GET['class_id'];

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
<!-- <link href="worksheet-data.css" rel="stylesheet" type="text/css" /> -->

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
<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> <span class='name'> ".$_SESSION['user_name']."</span>"."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div><!--  end header div -->
<div id="viewport">
	<div class="content" id="page1">
	<div id="code-info">Enrollment Code: <input type="text" id="enroll-code" value="<?php echo $class['enroll_code']; ?>" /><a class="btn" id="save-new-code">Save New Enrollment Code</a><span id="saved"></span></span></div>
	<div id="instructions-class-stories"> Instructions: Drag stories  to your Class list to add them to your class. Drag stories from your class list to remove them.</div>
	<ul id="all" class="connectedSortable"></ul>
	<ul id="class" class="connectedSortable"></ul>
<?php
	$query = "Select story_id, story_name from Stories";
	$run = mysql_query($query) or die(mysql_error());
	while ($results = mysql_fetch_assoc($run)) {
		$query = "Select * from Class_Stories where class_id='$class_id' and story_id = '".$results['story_id']."'";
		$check = mysql_query($query) or die(mysql_error());
		if (mysql_num_rows($check)<1) {
			$action = <<<EOF
			<script type='text/javascript'>
			$('#all').append("<li id='story[{$results['story_id']}]'>{$results['story_name']}</li>");
			</script>
EOF;
		}
		else {
			
			$action = <<<EOF
			<script type='text/javascript'>
			$('#class').append("<li id='story[{$results['story_id']}]'>{$results['story_name']}</li>");
			</script>
EOF;
		
		}
	echo $action;
	
	}
	
	?>		
	
		

	
	
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
	<li>Class Information</li>
	<li>Class Members</li>
	<li><a href='../index.php'>Main Menu</a></li>
	</ul>

</div>
	<div id="fadebackground"></div>
	<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

