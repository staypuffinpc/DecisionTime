<?php
//google authentication function
function google() {
	require 'openid.php';
	try {
	    $openid = new LightOpenID;
	    $openid->required = array('contact/email', 'namePerson/first', 'namePerson/last');
	/* 	$openid->realm="http://*.ipt.byu.edu/"; */
		if(!$openid->mode) {
	        if(isset($_GET['login'])) {
	            $openid->identity = 'https://www.google.com/accounts/o8/id';
	            header('Location: ' . $openid->authUrl());
	        }
	    } elseif($openid->mode == 'cancel') {
	        echo 'User has canceled authentication!';
	    } else {
	        if($openid->validate()){
	            $userAttributes = $openid->getAttributes();
	            $firstName = $userAttributes['namePerson/first'];
	            $lastName = $userAttributes['namePerson/last'];
	            $email = $userAttributes['contact/email'];
	            $user_image = "../img/google.png";
	            $user_profile = $openid->identity;
	         	$user_name = $firstName." ".$lastName;
	         	$provider = "google";
	       		/* Depending on the url this provides absolute links to the files that are needed for every file. */
				$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
				include_once($base_directory."/connectProject301.php");
				$link=connect(); //call function from external file to connect to database
				/* this is the end of the includes. */
				
				// query to find the user in the database
				$query = "Select * From Users Where user_email='$email' and provider='google'";
				$list = mysql_query($query) or die(mysql_error()); //execute query
				$user = mysql_fetch_assoc($list);//gets info in array
				// end of query
				
				//inserts unrecognized user into the database	
				if ($user['user_id'] == NULL) { 
					$message = $user_name.", your user information has been added to the system.";
					$query = "INSERT INTO Users (user_id, user_name, user_email, user_profile, provider, created, role, user_image) VALUES (null,'$user_name','$email','$user_profile','google', NOW(), 'Student', '$user_image')";
					$list = mysql_query($query) or die(mysql_error()); //execute query
					$query = "Select * From Users Where user_email='$email' and provider='google'";
					$list = mysql_query($query) or die(mysql_error()); //execute query
					$user = mysql_fetch_assoc($list);//gets info in array
				}
				else { //this will update the database with the last access time
					$query = "Update Users Set user_profile='$user_profile', last_access=NOW() where user_email='$email' and provider='google'";
					$list = mysql_query($query) or die(mysql_error()); //execute query
					$message = "Welcome back, ".$user['user_name'].".";
					setcookie("user",$user['user_name'], time()+3600, "/",".byuipt.net");
				}
				if(!isset($_SESSION)){session_start();}
				$_SESSION['user_id'] = $user_id = $user['user_id'];
				$_SESSION['user_name'] = $user['user_name'];
				$_SESSION['role']= $user['role'];
				$_SESSION['user_image'] = $user['user_image'];
				$_SESSION['admin'] = false;
	
				/* if ($user['admin'] == 1) {$_SESSION['admin'] = "yes";} //commented out to see if needed 8/17/2011 */
				include_once('dashboard.php');
			}
			else{
				$home_url = "http://".dirname(dirname($_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']));			
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=$home_url'>";
			}
        //echo 'User ' . ( ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
        }
	} //end try 
	catch(ErrorException $e) {
		echo $e->getMessage();
	} //end catch
}

//yahoo login function
function yahoo() {
	require 'openid.php';
	try {
	    $openid = new LightOpenID;
	    $openid->required = array('contact/email','namePerson','media/image/default');
		
	    if(!$openid->mode) {
	        if(isset($_GET['login'])) {
	            $openid->identity = 'http://me.yahoo.com/';
	            header('Location: ' . $openid->authUrl());
	        }
	
	    } elseif($openid->mode == 'cancel') {
	        echo 'User has canceled authentication!';
	    } else {
	        if($openid->validate()){
	            $userAttributes = $openid->getAttributes();
	            $user_image = "../img/yahoo.png";
	            $email = $userAttributes['contact/email'];
	            $user_profile = $openid->identity;
	         	$user_name = $userAttributes['namePerson'];
	         	$provider = "yahoo";
	       		/* Depending on the url this provides absolute links to the files that are needed for every file. */
				
				$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
				include_once($base_directory."/connectProject301.php");
				$link=connect(); //call function from external file to connect to database
				/* this is the end of the includes. */
				
				// query to find the user in the database
				$query = "Select * From Users Where user_email='$email' and provider='yahoo'";
				$list = mysql_query($query) or die(mysql_error()); //execute query
				$user = mysql_fetch_assoc($list);//gets info in array
				
				//inserts unrecognized user into the database	
				if ($user['user_id'] == NULL) { // this is to replace the previous gigya login
					$message = $user_name.", your user information has been added to the system.";
					$query = "INSERT INTO Users (user_id, user_name, user_email, user_profile, provider, created, role, user_image) VALUES (null,'$user_name','$email','$user_profile','yahoo',NOW(), 'Student', '$user_image')";
					$list = mysql_query($query) or die(mysql_error()); //execute query
					$query = "Select * From Users Where user_email='$email' and provider='yahoo'";
					$list = mysql_query($query) or die(mysql_error()); //execute query
					$user = mysql_fetch_assoc($list);//gets info in array
				}
	
				else {
					//this will update the database with the last access time				
					$query = "Update Users Set user_profile='$user_profile', last_access=NOW() where user_email='$email' and provider='yahoo'";
					$list = mysql_query($query) or die(mysql_error()); //execute query
					$message = "Welcome back, ".$user['user_name'].".";
					setcookie("user",$user['user_name'], time()+3600, "/",".byuipt.net");
				}
				if(!isset($_SESSION)){session_start();}
				$_SESSION['user_id'] = $user_id = $user['user_id'];
				$_SESSION['user_name'] = $user['user_name'];
				$_SESSION['user_image'] = $user['user_image'];
				$_SESSION['role']= $user['role'];
				$_SESSION['admin'] = false;
				
				/* if ($user['admin'] == 1) {$_SESSION['admin'] = "yes";} //commented out to see if needed 8/17/2011 */
				include_once('dashboard.php');
			}
			else{
				$home_url = "http://".dirname(dirname($_SERVER['SERVER_NAME']."".$_SERVER['REQUEST_URI']));			
				echo "<meta HTTP-EQUIV='REFRESH' content='0; url=$home_url'>";
			}
        //echo 'User ' . ( ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
        }
	} //end try 
	catch(ErrorException $e) {
		echo $e->getMessage();
	} //end catch
}

function facebook() {
	$app_id = "176079105779474";
	$app_secret = "48296dba973555d5aab064c9cf904761";
	$my_url = "http://ipt.byu.edu/isee/dashboard/facebook.php";
	$code = $_REQUEST["code"];
	
	if(empty($code)) {
		$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)."&scope=email";
		echo("<script> top.location.href='" . $dialog_url . "'</script>");
	}
	
	$token_url = "https://graph.facebook.com/oauth/access_token?" . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_secret . "&code=" . $code;
	$response = file_get_contents($token_url);
	$params = null;
	parse_str($response, $params);
	
	$graph_url = "https://graph.facebook.com/me?access_token=". $params['access_token'];
	$user = json_decode(file_get_contents($graph_url));
	$email = $user->email;
	$user_profile = $user->link;
	$user_name = $user->name;
	$user_image = "../img/facebook.png";
	$provider = "facebook";
	 		
	/* Depending on the url this provides absolute links to the files that are needed for every file. */
	$base_directory = dirname(dirname(dirname(dirname(__FILE__))))."/connectFiles";
	include_once($base_directory."/connectProject301.php");
	$link=connect(); //call function from external file to connect to database
	/* this is the end of the includes. */
	
	// query to find the user in the database
	$query = "Select * From Users Where user_email='$email' and provider='facebook'";
	$list = mysql_query($query) or die(mysql_error()); //execute query
	$user = mysql_fetch_assoc($list);//gets info in array
	
	//inserts unrecognized user into the database	
	if ($user['user_id'] == NULL and $email !== NULL) { 
		$message = $user_name.", your user information has been added to the system.";
		$query = "INSERT INTO Users (user_id, user_name, user_email, user_profile, UID, provider, created, role, user_image) VALUES (null,'$user_name','$email','$user_profile','$UID','facebook',NOW(), 'Student', '$user_image')";
		$list = mysql_query($query) or die(mysql_error()); //execute query
		$query = "Select * From Users Where user_email='$email' and provider='facebook'";
		$list = mysql_query($query) or die(mysql_error()); //execute query
		$user = mysql_fetch_assoc($list);//gets info in array
	}
	
	else { //this will update the database with the last access time
		$query = "Update Users Set user_profile='$user_profile', last_access=NOW() where user_email='$email' and provider='facebook'";
		$list = mysql_query($query) or die(mysql_error()); //execute query
		$message = "Welcome back, ".$user['user_name'].".";
		setcookie("user",$user['user_name'], time()+3600, "/",".byuipt.net");
	}
	if(!isset($_SESSION)){session_start();}
	$_SESSION['user_id'] = $user_id = $user['user_id'];
	$_SESSION['user_name'] = $user['user_name'];
	$_SESSION['user_image'] = $user['user_image'];
	$_SESSION['role']= $user['role'];
	$_SESSION['admin'] = false;
	
	/* if ($user['admin'] == 1) {$_SESSION['admin'] = "yes";} //commented out to see if needed 8/17/2011 */
	include_once('dashboard.php');
	//echo 'User ' . ( ? $openid->identity . ' has ' : 'has not ') . 'logged in.';
}

$function = $_GET['provider'];
$function();