<?php
require 'php_header.php';
require 'admin.php';
require 'javascript.php';

function drop_down_language($lan,$id){
global $language_array;
	echo "<tr><td>";
	echo "Language</td><td>\n";
	echo "<select name='lan'>\n";
	for ($i=0;$i<sizeof($language_array);$i++){
		echo "<option  value='".$language_array[$i]."' ".($language_array[$i]==$lan?"selected":"").">".$language_array[$i]."</option>\n";
	}
	echo "</select>\n";
	echo "</tr></td>\n";
}

$id= $_REQUEST['id'];
echo "<div id='foot_main'>\n";
echo "<h3> User profile</h3>\n";
connect_to_eurodb();
if ($id){
	$query="SELECT * FROM users WHERE id='$id'";
	//echo $query;
	$result=mysql_query($query);
	$num=mysql_numrows($result);

	$username=mysql_result($result,0,"username");
	$first_name=mysql_result($result,0,"first_name");
	$last_name=mysql_result($result,0,"last_name");
	$nickname=mysql_result($result,0,"nickname");
	$country=mysql_result($result,0,"country");
	$city=mysql_result($result,0,"city");
	$comments=mysql_result($result,0,"comments");
	$age=mysql_result($result,0,"age");
	$contact=mysql_result($result,0,"contact");
	$language=mysql_result($result,0,"language");
	$email=mysql_result($result,0,"email");
	
	echo "<table width=40% border=0  cellspacing=2	 cellpadding=0>\n
	<tr><td><font color=green>";
	echo "<b>".$first_name." ".$last_name."</b></font>\n";
	if ($nickname){echo "...alias <b>".$nickname."</b><br><br></td></tr>\n";}
	echo "<tr><td><b>Location:</b>".$city.", ".$country.".<br>\n";
	echo "<b>Age: </b>".$age."<br>\n";
	echo "<b>Comments: </b>".$comments."<br>\n";
	echo "</td></tr>";
	echo "</table>";
	echo "<a href='make_player.php?id=$id'> make player </a>&nbsp;/&nbsp;";
	echo "<a href='make_non_player.php?id=$id'> remove player </a>";
	echo "<form name='form1' method='post' action='ad_set_user_password.php'>";
	echo "<input name='username' type='text' size='30' value='$username'>";
	echo "<input name='pass' type='password' size='30'>";
	echo "<input name='email' type='text' size='30' value='$email'>";
	echo "<table>\n";
	drop_down_contact($contact);
	drop_down_language($language,$id);
	echo "</table>\n";
	echo "<input name='id' type='hidden' value='$id'>";
	echo "<input type='submit' value='submit'>";
	echo "</form>";
 }
 else echo "No id provided!";
?>
