<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story_id = $_SESSION['story'];
$query = "Select * from Stories where story_id='$story_id'";
$run = mysql_query($query) or die(mysql_error());
$story_info = mysql_fetch_assoc($run);








?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Quiz Editor: <?php echo $story_info['story_topic']; ?>: <?php echo $story_info['story_name']; ?></title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />


<link href="quiz.css" rel="stylesheet" type="text/css" />
  
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="quiz.js"></script>

</head>
<body>
<div id="header">Quiz Editor: <?php echo $story_info['story_topic']; ?>: <?php echo $story_info['story_name']; ?>
<a id="home" class="upperLeft" href="../../dashboard/index.php"></a>
<a id="back" class="upperLeft" href="../../story/quiz.php"></a>
<a id="saveMap" class="upperLeft" href="../../admin/map/index.php"></a>
<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../logout.php">Logout</a></div>

</div>
<div id="toolbar">
<a class="mc newItem btn" id="newMultipleChoiceItem">Add New Multiple Choice Item</a>
<a class="fb newItem btn" id="newFillInTheBlankItem">Add New Fill in the Blank Item</a>

</div>

<div id="viewport">
<div class="content">

<ul id="item-list"></ul>
</div>
</div>

</script>
<div id="ajax">Processing<img src="../../img/ajax-loader.gif" /></div>

<div id="popup"><div class="close-icon"></div><div id="popup-content"></div></div>

<div id="update"></div>
</body>



</html>