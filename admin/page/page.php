<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$user_id = $_SESSION['user_id'];//gets user info
if(isset($_GET['left'])) {$left = $_GET['left'];}else {$left = 1;}
if(isset($_GET['top'])) {$top = $_GET['top'];}else {$top = 1;}
$page_id = $_GET['page_id']; if ($page_id<1){$page_id = $_SESSION['current_page'];}//gets page id
/* $_SESSION['current_page'] = $page_id;//sets session */

$story = $_SESSION['story'];

/*
$story=$page['story'];//gets story
$_SESSION['story']=$story; // sets session story
*/
include_once("../../story/db.php");//gets mysql common calls


$query = "Select * from Worksheet where worksheet_story='$story' and embedded='1' and worksheet_page = '$page_id' order by worksheet_order ASC";
$run = mysql_query($query) or die(mysql_error());

$query = "Select page_name, id from Pages where story='$story' and page_type='Teaching'";
$pages = mysql_query($query) or die(mysql_error());

$i = 0; //this is getting the item sorter ready.
?>

<!DOCTYPE >
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0, maximum-scale=1.0, user-scalable=0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<script type="text/javascript">
    _editor_url  = "../../xinha/";  // (preferably absolute) URL (including trailing slash) where Xinha is installed
    _editor_lang = "en";      // And the language we need to use in the editor.
    _editor_skin = "blue-metallic";   // If you want use a skin, add the name (of the folder) here
</script>
<script type="text/javascript" src="../../xinha/XinhaCore.js"></script>
<script type="text/javascript" src="../../xinha/my_config.js"></script>

<title></title>

<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="page.css" rel="stylesheet" type="text/css" />
<link href="../../styles/image-creator.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="page.js"></script>

<script type="text/javascript">
var itemOrder = new Array();

<?php if ($story == NULL) {?>
window.location = "../../index.php";
<?php
}
?>


</script>

</head>
<body>
<form>	<input type="hidden" id="page_id" name="page_id" value="<?php echo $page_id ?>" />

<div id="header">
	<?php echo $page['story_name']; ?>  	
<a id="home" class="upperLeft" href="../../dashboard/index.php"></a>
<a id="back" onClick="view(<?php echo $page_id; ?>);" class="upperLeft" title="Save and go to story."></a>
<a id="saveMap" class="upperLeft" onClick="update_exit(<?php echo $left; ?>, <?php echo $top; ?>, <?php echo $page_id; ?>);"></a>
<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../../logout.php">Logout</a></div>
</div>

<div id="viewport">
<div class="content" id="page1">
<input type="text" name="page_name" id="page_name" value="<?php echo $page['page_name'];?>" />

<textarea name="content" id="content">
		<?php echo $page['page_content']; // Gets Content ?>
</textarea>
<div id="hiddenDiv"><?php echo $page['page_content']; // Gets Content ?></div>

	<div id="worksheet">
	<h3>Worksheet</h3>
	<div class="options">
	<a class='btn newItem' id='multiple_choice'>New Multiple Choice Item</a>
<a class='btn newItem' id='true_false'>New True/False Item</a>
<a class='btn newItem' id='fill_in_the_blank'>New Fill in the Blank Item</a>
<a class='btn newItem' id='short_answer'>New Short Answer Item</a>
</div>
	<ul id="item-list">
<?php	
	while ($results = mysql_fetch_assoc($run)) {
		
		if (strlen($results['worksheet_text']) > 88) {
			$text = substr($results['worksheet_text'], 0, 87)." . . .";
		} else $text = $results['worksheet_text'];
		echo <<<EOF
			<li id='item[{$results['worksheet_id']}]' class='ui-state-default'>
			<div class='number'>{$results['worksheet_order']}. </div><div class='type'>{$results['worksheet_type']}</div> 
EOF;
		echo <<<EOF
		<div class="item-info"><div class="label">Text: </div><div class="ce text {$results['worksheet_id']}" contenteditable>{$results['worksheet_text']}</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Response: </div><br />		
EOF;

		switch ($results['worksheet_type']) {
			case "Short Answer":
				echo "<div><textarea disabled='disabled' ></textarea></div>";
				break;
			case "Fill in the Blank":
				echo "<div><input type='text' disabled='disabled' /></div>";
				break;
			case "True or False":
				echo "<div><input type='radio' disabled='disabled'>True<br>
				<input type='radio' disabled='disabled'>False<br></div>";
				break;
			case "Multiple Choice":
				echo "<div class='theresponse {$results['worksheet_id']}'>";
				echo $results['worksheet_response'];
				echo "</div><script>$('.response').attr('contenteditable', true);</script>";		
		}
		
		
		
		
		echo "<div class='spaceTaker'></div>";

		if ($results['worksheet_type'] == "Multiple Choice") { echo "<div class='addItem ".$results['worksheet_id']."'>Add Item</div><div class='removeItem ".$results['worksheet_id']."'>Remove Item</div>";}
		echo <<<EOF
		<div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Answer: </div><br /><div class="ce answer {$results['worksheet_id']}" contenteditable>{$results['worksheet_answer']}</div><div class="spaceTaker"></div></div>
		<div class="item-info"><div class="label">Page: </div><select class="{$results['worksheet_id']}"><option>None Selected</option>
EOF;
		while ($resultsPages = mysql_fetch_array($pages)) {
			echo "<option value='".$resultsPages['id']."'";
		if ($resultsPages['id'] == $results['worksheet_page']) {echo " selected ";}
		echo ">".$resultsPages['page_name']."</option>";
		}
		echo "</select></div>";
		echo <<<EOF
		<div class="item-info"><div class="label">Embedded: </div><div class='embeddedContainer'>
		<input class='{$results['worksheet_id']}' type='checkbox'
EOF;
		if ($results['embedded'] == 1) {echo " checked ";}
		echo "/></div></div>";		
		echo <<<EOF
			<div title='Remove this item' class='delete' id='delete{$results['worksheet_id']}'>x</div></li>
EOF;
			
		mysql_data_seek($pages, 0);	
		echo <<<EOF
		<script> itemOrder[$i] = {$results['worksheet_order']}-1; //console.log("$i"+itemOrder[$i]);</script>
EOF;
$i++;} 
?>
</ul>
	
	</div>
	<div id="navigation">
	<h3>Navigation Prompt</h3>
		<input size="80" name="page_navigation_text" id="page_navigation_text" value="<?php echo $page['page_navigation_text']; ?>" />
		<div class="options">
			<a class="btn" id="addSubheading">Add a Navigation Subheading</a>
		</div>
		<ul id="navigation_choices">
		<?php 
	while ($results_nav = mysql_fetch_assoc($list_nav)) { //generate choice
			echo "<li class='ui-state-default";
			if ($results_nav['page_external'] == "true") {echo " externalLink' ";} else {echo "' ";}
			 
			echo "id='item[".$results_nav['page_relation_id']."]'>
				<a class='deleteLink' id='delete".$results_nav['page_relation_id']."'>x</a>
				<span class='page_stem ".$results_nav['page_relation_id']."'>".$results_nav['page_stem']." </span>	
				<span class='page_link ".$results_nav['page_relation_id']."'>".$results_nav['page_link']."</span>
				<span class='page_punctuation ".$results_nav['page_relation_id']."'>".$results_nav['page_punctuation']."</span>
				<div class='page_ending'></div></li>";
				
	}		
		 
	
	
	//end generate buttons
	?>
	</ul>
</div> <!-- end navigation div -->

<?php 

echo "<hr><h3>References</h3>";
echo "<textarea name='references' id='references'>".$page['page_references']."</textarea>";
?>
</div>
<div id="borrowedContentPane"><?php include('ajax/contentBorrower.php'); ?>
</div>
</div>
<div id="menu">
	<h1>Menu</h1>
	<h2>Page Options</h2>

	<p><input name="page_type" type="radio" value="Story" <?php if ($page['page_type'] == "Story") {echo " checked";} ?> />Story</p>
	<p><input name="page_type" type="radio" value="Teaching" <?php if ($page['page_type'] == "Teaching") {echo " checked";} ?> />Teaching</p>
	<p><input name="page_type" type="radio" value="" <?php if ($page['page_type'] == "") {echo " checked";} ?> />Nothing</p>


	<h2>Summary</h2>
	<?php if ($page['id'] == $page['story_summary']) {echo "<p>This is the Summary page.</p>";}
	else { ?>
	<p><input name="page_summary" type="radio" value="0"<?php if ($page['page_summary'] == 0) {echo " checked";}?> />Do Not Include in the Summary</p>
	<p><input name="page_summary" type="radio" value="1"<?php if ($page['page_summary'] == 1) {echo " checked";}?> />Include in the Summary</p>

	<?php } ?>
	<h2>Tools</h2>
	<a class="dbutton" id="imageCreator">Image Creator</a>
	
</div>
<div id="footer">

<ul>
	<li id="save" onClick="update_page();"><img src="../../img/save.png" /><br />Save</li>
	<li id="save-return" onClick="update_exit(<?php echo $left; ?>, <?php echo $top; ?>, <?php echo $page_id; ?>);"><img src="../../img/saveMap.png" /><br />Save (Map)</li>
	<li id="view" onClick="view(<?php echo $page_id; ?>);"><img src="../../img/saveStory.png" /><br />Save (Story)</li>
	
</ul>

</div> <!-- end footer -->
<a id="menuToggle" class="footerToggle">Show Menu</a>
<a id="borrowToggle" class="footerToggle">View Content Borrower</a>
<div id="update"></div>
<div id="status"></div>
<div id="ajax">Processing<img src="../../img/ajax-loader.gif" /></div>
<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>
<div id="fadebackground"></div>
</form>

</body>
</html>