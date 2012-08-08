<?php
$base_directory = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))."/connectFiles";
include_once($base_directory."/connectProject301.php");
include_once($base_directory."/authenticate.php");
$link=connect(); //call function from external file to connect to database
/* this is the end of the includes. */
//$user_id = $_SESSION['user_id'];
$story = $_GET['story'];
/* $story = 1; */
$class_id = $_SESSION['class_id'];
/* echo $story." ".$class_id."<br>"; */


$query_worksheet = "select 
	u.user_name,
	uq.user_id,
	qi.item_id,
	qi.item_type,
	uq.user_answer,
	qi.worksheet_order,
	qi.worksheet_text,
	qi.worksheet_response 
from 
	User_Quiz uq,
	Users u,
	Quiz_Items qi,
	Class_Members cl
where
 	ua.user_id = u.user_id
 	and
 	ua.worksheet_id = a.worksheet_id
 	and
 	cl.user_id = u.user_id
 	and
 	cl.class_id = '$class_id'
order by
	ua.worksheet_id asc,
	ua.user_id asc"; //mysql query variable


/* $query_worksheet = "Select * from Users, User_Worksheet, Worksheet, Class_Members Join Users.user_id = User_Worksheet AND User_Worksheet.worksheet_id = Worksheet.worksheet_id and Users.user_id = Class_Members.user_id where class_id = '$class_id'"; */
$list_worksheet = mysql_query($query_worksheet) or die(mysql_error()); //execute query
$worksheet = mysql_fetch_assoc($list_worksheet);//gets info in array

$query_worksheet_order = "select * from Worksheet where worksheet_story = '$story' order by worksheet_order asc";
$list_worksheet_order = mysql_query($query_worksheet_order) or die(mysql_error()); //execute query
$worksheet_order = mysql_fetch_assoc($list_worksheet_order);//gets info in array
$worksheet_count = mysql_num_rows($list_worksheet_order); //gets number of links

$answers = array();
$users = array();
$usercount = 0;

do {
	if(in_array($worksheet['user_id'], $users)){} else {$users[] = $worksheet['user_id']; $usercount++;}
	$answers[$worksheet['user_id']][$worksheet['worksheet_order']."t"] = $worksheet['worksheet_type'];
	echo <<<EOF
		<div id = "worksheet_text{$worksheet['worksheet_order']}" class="worksheet-text">
		{$worksheet['worksheet_order']}. {$worksheet['worksheet_text']} <br /> {$worksheet['worksheet_response']}
		</div>
EOF;

	 
	$answers[$worksheet['user_id']][0] = $worksheet['user_name'];
	$answers[$worksheet['user_id']][$worksheet['worksheet_order']] = $worksheet['user_answer'];
} while ($worksheet = mysql_fetch_assoc($list_worksheet));

?>

<h2>Worksheet Data</h2>
<div id="tabular-data-table">
<table id="tabular-data">
<tr>
<td class='header' width="200px">Name</td>
<?php
do {
	echo "<td class='header width-setter ".$worksheet_order['worksheet_order']."' id='".$worksheet_order['worksheet_order']."'>".$worksheet_order['worksheet_order']."</td>";
	}
while ($worksheet_order = mysql_fetch_assoc($list_worksheet_order));

?>


</tr>

<?php




for ($i=0; $i<$usercount; $i++) {
	echo "<tr>";
	for ($j=0; $j<=$worksheet_count; $j++) {
		if ($j == 0) {	echo "<td>".$answers[$users[$i]][$j]."</td>"; }
		
		else {
		if (isset($answers[$users[$i]][$j."t"])){
		switch ($answers[$users[$i]][$j."t"]) {
			case NULL:
				echo "<td></td>";
				break;
			case "Multiple Choice":
				echo "<td style='text-align:center;'>";
				switch ($answers[$users[$i]][$j]) {
					case 0:
						echo "A";
						break;
					case 1:
						echo "B";
						break;
					case 2:
						echo "C";
						break;
					case 3:
						echo "D";
						break;
					case 4:
						echo "E";
						break;
					case 5:
						echo "F";
						break;
					case 6:
						echo "G";
						break;
					case 7:
						echo "H";
						break;
					case 8:
						echo "I";
						break;
					case 9:
						echo "J";
						break;
					case 10:
						echo "K";
						break;
					case 11:
						echo "L";
						break;
				} //end case switch
				
				echo "</td>";
			break;
			case "True or False":
				echo "<td style='text-align:center;'>";
				if ($answers[$users[$i]][$j] == 0) {echo "T";}
				if ($answers[$users[$i]][$j] == 1) {echo "F";}
				echo "</td>";
				break;
			case "Short Answer":
				echo "<td title='".$answers[$users[$i]][$j]."'  style='text-align:center;'>?</td>";	
				break;
			case "Fill in the Blank":
				echo "<td title='".$answers[$users[$i]][$j]."'  style='text-align:center;'>?</td>";	
				break;
		} //end switch
		} else {echo "<td></td>";}
		} //end else
		} //end for
	echo "</tr>";
} //end for


?></table>
</div>
<div id="tabular-data-info">
	<div id="inner">
	Click on a Question Number at the top to see the question text.
	</div>
</div>
<script>
	$("tr:odd").css("background-color", "#CCCCCC");
	child = 0;
	$("td").click(function(){
		$("tr:odd td:nth-child("+child+")").css("background-color","#CCCCCC");
		$("tr:even td:nth-child("+child+")").css("background-color","#FFFFFF");

		$("tr:odd").css("background-color", "#CCCCCC");
		$("tr:even").css("background-color", "#FFFFFF");
		child = $(this).index()+1;
		target = child-1;
		$("tr td:nth-child("+child+")").css("background-color","#FFFFCC");
		$("#inner").html($("#worksheet_text"+target).html()).css("text-align", "left");
	});
</script>
