<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
$story = $_SESSION['story'];
$page_id = $_SESSION['current_page'];
include_once("../db.php");



?>
<!DOCTYPE html>
<html>
<head>

<title><?php echo "Decision Time - Term Editor"; ?>
</title>
<link href="../../styles/style.css" rel="stylesheet" type="text/css" />
<link href="../../styles/stylist.css" rel="stylesheet" type="text/css" />
<link href="terms.css" rel="stylesheet" type="text/css"type="text/css"/>
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>	



<script type="text/javascript">
    _editor_url  = "../../xinha/";  // (preferably absolute) URL (including trailing slash) where Xinha is installed
    _editor_lang = "en";      // And the language we need to use in the editor.
    _editor_skin = "blue-metallic";   // If you want use a skin, add the name (of the folder) here
  </script>
  <script type="text/javascript" src="../../xinha/XinhaCore.js"></script>
  <script type="text/javascript" src="../../xinha/my_config_term.js"></script>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<script type="text/javascript" src="../../js/common.js"></script>

<script type="text/javascript" src="terms.js"></script>
<script type="text/javascript">
</script>
</head>
<body>
<div id="header"><?php echo $story_info['story_name'].": Term Editor"; ?>
<a id="home" class="upperLeft" href="../../dashboard/index.php"></a>
<a id="back" class="upperLeft" href="../../story/index.php?page_id=<?php echo $page_id;?>&page2=glossary"></a>
<a id="saveMap" class="upperLeft" href="../../admin/map/"></a>
<div id="greeting"><?php echo "<img src='../".$_SESSION['user_image']."'/> <span class='name'> ".$_SESSION['user_name']."</span>"; ?><a id="logoutFromMenu" class="btn blockButton" href="../../logout.php">Logout</a></div>
</div>
<div id="toolbar">
<a class="btn" id="new-term">Add New Term</a>
<a class="btn" id="findTerms">Add Unlisted Key Terms</a>
</div>
<div id="viewport">
<div class="content">
<?php include_once("ajax/term.php"); ?>
</div>
</div>
<div id="update">
</div>
