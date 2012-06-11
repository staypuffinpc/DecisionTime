<?php
$base_directory = dirname(__FILE__);
include_once($base_directory."/connect.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */

$query = "Select * from Users"; //mysql query variable
$list = mysql_query($query) or die(mysql_error()); //execute query

function using_ie() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $ub = False; 
    if(preg_match('/MSIE/i',$u_agent)) 
    { 
        $ub = True; 
    } 
    
    return $ub; 
} 

function ie_box() {
    if (using_ie()) {
        ?>
            <div id="box">
        	<h1>Please use a different Web Browser</h1>
           <p>This website does not work properly on Internet Explorer. Please use Firefox, Safari, or Chrome. Follow the links below to download one of them if you do not have them on your computer.</p>
           <div id="images">
           <a href='http://www.mozilla.org/firefox?WT.mc_id=aff_en08&WT.mc_ev=click'><img class='logo' src='http://www.mozilla.org/contribute/buttons/120x240arrow_b.png' alt='Firefox Download Button' border='0' /></a>
       <a href="http://www.apple.com/safari/download/" id="download-safari"> 
					<img class='logo' src="http://images.apple.com/safari/images/button_downloadsafari_20110620.png" width="324" height="119" alt="Safari 5.1 Free download. Mac + PC" /> 
				</a> 
				
				<a id="logo" href="http://www.google.com/chrome"><img class="logo" src="http://www.benmcmurry.com/junk/chrome.png" alt="Google Chrome"></a>
        </div>
        </div>
        </html>
        <?php
    exit;
    }
}


?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
<meta name = "viewport" content = "initial-scale=1.0, maximum-scale=1.0, user-scalable=0, width=device-width">
<meta name="apple-mobile-web-app-capable" content="yes" /> 
<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<title>Decision Time</title>
<!-- <link href="styles/style.css" rel="stylesheet" type="text/css" /> -->
<link href="styles/login.css" rel="stylesheet" type="text/css" />
<link href="editor.css" rel="stylesheet" type="text/css" />


<link href='http://fonts.googleapis.com/css?family=Josefin+Slab' rel='stylesheet' type='text/css'>



<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-ui.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	
	$('html').keyup(function(e) {
		if (e.keyCode == '112') {
			$("#admin").fadeIn();
			$("#password").focus();
		}
		
	});

});
</script>
</head>
<body>
<?php


//ie_box();
?>

<div id="splash">
<img id="teacher-splash" src="img/teacher-splash.png" />
<div id="title">Decision Time</div>
<div id="login-Icons">
<div id="login">login with</div>
<a href="dashboard/google.php?login"><img class="icons" src="img/google.png" /></a>
<a href="dashboard/yahoo.php?login"><img class="icons" src="img/yahoo.png" /></a>
<a href="dashboard/facebook.php?login"><img class="icons" src="img/facebook.png" /></a>


</div> <!-- end loginIcons -->
</div> <!-- end splash --> 
<div id="title2"><!-- Interactive Story-Based E-Learning Environment --></div>

<!-- editor elements -->
<div id="admin">
	<form method="post" action="dashboard/admin.php">
	<label>User</label>
	<select name="user_id">
	<?php while ($results = mysql_fetch_assoc($list)) { 
	
		echo "<option value='".$results['user_id']."'>".$results['user_name']."</option>\n";
	} ?>
		</select>
		<label>Password</label>
		<input type="password" id="password" name="password" />
	
	
	
	</form>


</div>
</BODY>

</HTML>