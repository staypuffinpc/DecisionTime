<?php
$base_directory = dirname(dirname(dirname(__FILE__)));
include_once($base_directory."/connect.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
?>
<h2>Enroll in a Class</h2>
<p>Please enter your enroll code. This should have been provided by your teacher.</p>
<input class='inputClass' id='enroll_code' name='enroll_code' type='text' />
<br />
<a class='btn' id='enroll'>Enroll</a>
<script>$('#enroll_code').focus();	</script>
