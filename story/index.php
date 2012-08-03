<?php
$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$user_id = $_SESSION['user_id'];

/* Gets and/or Sets the current story */
if (!isset($_GET['story'])) {$story=$_SESSION['story'];}
else {$story = $_GET['story'];$_SESSION['story']=$story; }

/* checks to make sure there is a page to display */
if(!isset($_GET['page_id'])) {echo "<script>window.location = '../index.php'</script>";}//gets page id
else {$page_id = $_GET['page_id'];}
$_SESSION['current_page'] = $page_id; // puts page in a session variable

include_once("db.php"); // most of the db calls needed for this page
session_write_close();
$query = "Select * from Worksheet where worksheet_story='$story' and embedded='1' and worksheet_page='$page_id' order by worksheet_order ASC";
$run = mysql_query($query) or die(mysql_error());

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0, maximum-scale=1.0, user-scalable=0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>Decision Time - <?php echo $page['story_name']; // Gets Content ?> </title>
<link href="../styles/style.css" rel="stylesheet" type="text/css" />
<link href="story.css" rel="stylesheet" type="text/css" />
<link href="../styles/stylist.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-ui.js"></script>
<script type="text/javascript" src="../js/common.js"></script>

<script type="text/javascript" src="story.js"></script>
<script type="text/javascript" src="../js/jquery-scroll.js"></script>
<!--[if !IE]>
<script type="text/javascript" src="../js/scroll.js"></script>
<!-- makes things scroll on idevices -->
<![endif]-->




<script type="text/javascript">
var user = <?php echo $user_id; ?>; // sends php variable to js
var story = <?php echo $story; ?>;  // sends php variable to js
var page = <?php echo $page_id; ?>; // gets php variable
var author = false;
<?php if ($author) {echo "author = true;";} ?>
$(document).ready(function(){
	<?php if ($_SESSION['admin']) {// sets the header color to red to identify that admin is logged in. ?>
	$("#header, #greeting").css({
		"color" : "red"
	});
	author = true;
	//console.log("admin");
	<?php 
	
	
	}
	
	if (!mysql_num_rows($run)) { //hides worksheet section if there are no embedded questions. ?>
		$(".worksheet").hide(); 
	
	<?php }
	$length = strlen($page['page_references']);
	if ($length<1) {echo "$('#references').hide();";} 
	if ($user['instructionsShowing'] == "false") {echo "$('.page-instructions').hide();";}
	if (mysql_num_rows($list_nav)<1) {echo "$('#navigation').hide();";}
	if ($current_worksheet > 0) {echo "worksheet_announce(".$current_worksheet.");"; }
	if ($author) { echo "$('#edit').show();"; }
	else {echo "$('td.admin').remove();"; } 
	
	if (!$finish) { ?> //shows summary button if it is available to the user
		$("#summary-button").hide();

		$("#quiz-button").hide();
	<?php }
	if (!$quizAvailable) {echo "$('#quiz-button').hide();";}
	if ($author) { echo "$('#edit, #summary-button, #quiz-button').show();$('td.admin').remove();"; }
	?>
	$("#summary-button").click(function(){window.location="index.php?page_id=<?php echo $page['story_summary']; ?>";});
	//test
	$("#quiz-button").click(function(){window.location="quiz.php";});
	
	
	<?php
	if(isset($_GET['page2'])) {
	?>
		navigate("<?php echo $_GET['page2']; ?>");
	<?php
	}
	
	?>

});
<?php if ($user['instructionsShowing'] == "false") {echo "var instructionsShowing = false;";} else { echo "var instructionsShowing = true;";} ?>

</script>
</head>
<body>
<div id="header"><?php echo $page['story_name'].": ".$page['page_name']; // Gets Content ?> 
<a id="home" class="upperLeft" href="../dashboard/index.php"></a>
<a id="edit" href="../admin/page/page.php">edit</a>

<div id="greeting"><?php echo "<img src='".$_SESSION['user_image']."'/> <span class='name'> <span class='name'> ".$_SESSION['user_name']."</span>"."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

<a id="helpToggle">?</a>
</div>
<div id="viewport"> <!-- the viewport makes ipad functionality work -->
	<div class="content" id="page1">
	<h2><?php echo $page['page_name']; ?></h2>
<!--  		<div id="page-content"> -->
			<?php echo $page['page_content']; // Gets Content 
			if ($page['id'] == $page['story_summary']) { include("ajax/summary.php");}?>

		<div class="worksheet worksheet-embedded">
		<div id="check">check your understanding</div>
		<?php 
		while ($Aresults = mysql_fetch_assoc($run)) {
			echo "<h4>{$Aresults['worksheet_type']}</h4>";
			echo $Aresults['worksheet_text'];
			echo "<br />".$Aresults['worksheet_response'];
			$query = "SELECT * From User_Worksheet where user_id = '".$user_id."' and worksheet_id = '".$Aresults['worksheet_id']."'"; //mysql query variable
			$list = mysql_query($query) or die(mysql_error()); //execute query
			$answers = mysql_fetch_assoc($list);//gets info in array
	
			if ($answers['user_answer'] !== NULL) {
				if ($Aresults['worksheet_type'] == "Multiple Choice" || $Aresults['worksheet_type'] == "True or False") {
					?><script>$("input[name='<?php echo $Aresults['worksheet_id'];?>']")[<?php echo $answers['user_answer']; ?>].checked = true;</script><?php }
			 	if ($Aresults['worksheet_type'] == "Fill in the Blank") {
			 		?><script>$("input[name='<?php echo $Aresults['worksheet_id'];?>']").val("<?php echo $answers['user_answer']; ?>");</script><?php }
				if ($Aresults['worksheet_type'] == "Short Answer") {
			 		?><script>$("textarea[name='<?php echo $Aresults['worksheet_id'];?>']").val("<?php echo $answers['user_answer']; ?>");</script><?php }
			}
			
		}?>
		</div>
		
<!-- 		Displays navigation choices -->
		<div id="navigation">
			<div id="decision-time">decision time</div>
			<h3><?php echo $page['page_navigation_text']; ?></h3>
			<?php 
			if ($quizAvailable) {if ($page['id'] == $page['story_summary'] || $page['finish_page'] == "true") { echo "<h3>Take the <a href='quiz.php'>quiz</a>.</h3>";}}
			if ($page['finish_page'] == "true") {echo "<h3> See what you missed. Visit the <a href='index.php?page_id={$page['story_summary']}'>Summary Page</a>.";}
			while ($results_nav = mysql_fetch_assoc($list_nav)) { //generate choice
					/* echo "<p>".$results_nav['page_stem']." "; 	 */
					if ($results_nav['page_external']=="true"){
						$query = "Select story from Pages where id = '{$results_nav['id']}'";
						$run_external = mysql_query($query) or die(mysql_error());
						$results_external = mysql_fetch_assoc($run_external);
						$story = $results_external['story'];
					}
					if (strstr($results_nav['page_stem'], "<h3>")) {echo $results_nav['page_stem'];}
					else { 
						?>
						<p>
						<a id="navigation <?php echo $results_nav['id'];?>"  class="tracker" href="index.php?page_id=<?php echo $results_nav['id'];?>&story=<?php echo $story; ?>"><?php //makes page link 
	/* 					echo $results_nav['page_link']."</a>".$results_nav['page_punctuation']; */
						echo $results_nav['page_stem']." ".$results_nav['page_link'].$results_nav['page_punctuation']."</a>";
						?>
					</p> <?php 
					}
			}		
			//end generate buttons
			?>
		</div> <!-- end navigation div -->

<div id="references">
	<div id="references-title">references</div>
	<?php echo $page['page_references']; ?>
</div>

<!-- </div> <!-- end page content div --> 

<div class="page-instructions"><a class='page-instructions-toggle'> Use the 'i' key to toggle Instructions.</a>

<p>The purpose of this simulation is to help you not only learn the principles of <?php echo $page['story_topic'];?>, but see them in action.  Our hope is that by situating them in a story, they will be more memorable and easier to apply as you enter your chosen profession.</p>
<p>The simulation will lead you through the instruction and the story simultaneously.  Story pages present you with an actual context to apply the topics covered in this chapter.  On these pages, you’re given choices of what action you would like to take.  At times, you’ll “step out” of the story and be presented with an instructional page.  Instructional pages are presented “just in time,” to teach you a concept at the moment (or right before) you’ll see that concept play out in the story.</p>



</div>

</div> <!-- end page1 div -->
<div  id="page2" class="content"></div>
</div>
<div id="instructionsToggle" class="
	<?php 
	if ($user['instructionsShowing'] == "false") {echo 'notShowingInstructions';}
	else {echo 'showingInstructions';}
	?>

"><p>i</p></div>

<div id="footer">
	<ul>
		<li class="core" id="story"><div><img src="../img/story.png" /></div><p>Story</p></li>
		<li class="core" id="glossary"><div><img src="../img/glossary.png" /></div><p>Glossary</p></li>
<!-- 		<li class="core" id="discuss"><div><img src="../img/chat.png" /></div><p>Discuss</p></li> -->
<!-- 		<li class="core" id="appendices"><div><img src="../img/appendices.png" /></div><p>Appendices</p></li> -->
		<li class="core" id="worksheet"><div><img src="../img/worksheet.png" /></div><p>Answers</p><div id="worksheet_count"><?php echo $worksheet_count; ?></div></li>
		<li class="core" id="map"><div><img src="../img/map.png" /></div><p>Progress Map</p></li>
		<li class="finished" id="summary-button"><div><img src="../img/summary.png" /></div><p>Summary</p></li>
		<li class="finished" id="quiz-button"><div><img src="../img/quiz.png" /></div><p>Quiz</p></li>

	</ul>
	

</div>


<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>
<div id="fadebackground"></div>
<div id="update"></div>

<div id="definition" class="popup"><div class="close-icon"></div>
	<div id="definition-content">
	Definition goes here.
	</div>

</div>
</div>

<div id="worksheet_announce_window">
	<?php if ($current_worksheet == 1) {echo "You have unlocked 1 answer on the worksheet.";}
		else {echo "You have unlocked ".$current_worksheet." answers on the worksheet.";}
	?>
	<img src="../img/open.png" width="64px" />
</div>

<div id="help"><h1>Help Menu</h1>
<hr />
<div class="keyboardShortcuts">
<h2>Keyboard Shortcuts</h2>
<table class="shortcuts">
	<tr><td></td><td>Navigation</td><td class="admin"></td><td class="admin">Admin</td></tr>
	<tr><td><span class="key">esc </span> :</td><td>Goes Back to the Story</td><td class="admin"><span class='key'>e </span>:</td><td class="admin">Edit Current Page</td></tr>
	<tr><td><span class="key">h	</span> :</td><td>Home (dashboard)</td><td class="admin"><span class='key'>v </span>:</td><td class="admin">View Full Map</td></tr>
	<tr><td><span class="key">s </span> :</td><td>Story Page</td><td class="admin"><span class='key'>c </span>:</td><td class="admin">Clear Progress</td></tr>
	<tr><td><span class="key">g </span> :</td><td>Glossary</td><td class="admin"><span class="key">x </span>:</td><td class="admin">Clear Worksheet</td></tr>
	<tr><td><span class="key">d </span> :</td><td>Discuss</td><td class="admin"><span class="key">z </span>:</td><td class="admin">Clear Quiz</td></tr>
	<tr><td><span class="key">a </span> :</td><td>Appendices</td></tr>
	<tr><td><span class="key">w </span> :</td><td>Worksheet</td></tr>
	<tr><td><span class="key">m </span> :</td><td>Progress Map</td></tr>
	<tr><td><span class="key">i </span> :</td><td>Toggles Page Instructions</td></tr>

	<tr><td><span class="key">? </span> :</td><td>Toggles this Menu</td><td class="admin"></td><td class="admin"></td></tr>
</table>
</div>
<div class='help' id="help-home">
	<img src='../img/help-arrow.png' />
	<p>Use this icon or press "h" to go back to the main menu.</p>
</div>
<div class='help' id="help-help">
	<img src="../img/help-arrow.png" />
	<p>Use this icon or press "?" to open this help menu.</p>

</div>
<div class='help' id='help-instructions'>
<p>Use this icon or press "i" to show on-page instructions.</p>
	<img src="../img/help-arrow.png" />	

</div>
<div class='help' id='help-footer'>
		<img src="../img/help-arrow.png" />	
		<p>These icons in orange are always available. They provide additional resources while going through the story. See the table above for the keyboard shortcuts.<br /><br />
		Once you finish the story, you will have icons on the right that take you to the Summary page and the Quiz. </p>
	
</div>




</div>
<div id="popup" class="popup"><div class="close-icon"></div>
<div id="popup-content"></div> <!-- end popup-content -->
</div> <!-- end popup -->
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23109189-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>