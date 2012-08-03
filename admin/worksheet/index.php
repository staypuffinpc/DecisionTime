<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$user_id = $_SESSION['user_id'];
$story = $_GET['story'];
$page_id = $_SESSION['current_page'];

if (isset($_GET['left'])) {$left = $_GET['left'];} else {$left = 0;}
if (isset($_GET['top'])) {$top = $_GET['top'];} else {$top = 0;}


if ($story == NULL) {$story=$_SESSION['story'];}
else {$_SESSION['story'] = $story;}
include_once("../db.php");



?>
<html>
<head>
<title>Worksheet Editor: <?php echo $story_info['story_topic']; ?>: <?php echo $story_info['story_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />


<link href="worksheet.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="worksheet.js"></script>



<script type="text/javascript">
<?php if ($story == NULL) {?>
window.location = "../dashboard/";
<?php
}
?>
$(document).ready(function(){

});

</script>
</head>
<body>
<div id="header">Worksheet Editor: <?php echo $story_info['story_topic']; ?>: <?php echo $story_info['story_name']; ?>
<a id="home" class="upperLeft" href="../../dashboard/index.php"></a>
<a id="back" class="upperLeft" href="../../story/index.php?page_id=<?php echo $page_id;?>&page2=worksheet"></a>
<a id="saveMap" class="upperLeft" href="../../admin/map/"></a>
<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../../logout.php">Logout</a></div>

</div>


<div id="viewport">
<div class="content">
<div id="toolbar">
<a class='btn newItem' id='multiple_choice'>New Multiple Choice Item</a>
<a class='btn newItem' id='true_false'>New True/False Item</a>
<a class='btn newItem' id='fill_in_the_blank'>New Fill in the Blank Item</a>
<a class='btn newItem' id='short_answer'>New Short Answer Item</a>
</div>
<ul id="item-list"></ul>
</div>
</div>

</script>
<div id="ajax">Processing<img src="../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

</body>
</html>