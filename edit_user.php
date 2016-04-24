<?php
require 'authAdm.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';
require 'lib.php';

echo "<h3>Edit user profile</h3>";
// Query the database:

$user_id=$_REQUEST['user_id'];

connect_to_database();

if(!$user_id){
	$query="SELECT
		id,first_name,last_name,city,email,country,nickname,age,comments,sweet,player
		FROM users ORDER BY nickname  ";
	//echo "query: $query <br>\n";	
	$rez=mysql_query($query) or mysql_die();	
	$num=mysql_numrows($rez);
	if($num){
		if($num==1){echo "<p>".$num." result found.</p>";}
		else {echo "<p>".$num." results found.</p>";}  

		echo "<table border='1'>\n";
		echo "<tr>\n";
		echo "<td>Nickname</td>\n";
		echo "<td>Last Name</td>\n";
		echo "<td>First Name</td>\n";
		echo "<td>City</td>\n";
		echo "<td>Country</td>\n";
		echo "<td>Age</td>\n";
		echo "<td>Manager</td>\n";
		echo "<td>Player</td>\n";
		echo "<td>Email</td>\n";
		echo "<td>Comments</td>\n";
		echo "<td>&nbsp</td>\n";
		echo "<td>&nbsp</td>\n";
		echo "</tr>\n";
		$i=0;
		while($i<$num){

			$last_name=mysql_result($rez,$i,"last_name");
			$first_name=mysql_result($rez,$i,"first_name");
			$age=mysql_result($rez,$i,"age");
			$country=mysql_result($rez,$i,"country");
			$city=mysql_result($rez,$i,"city");
			$nickname=mysql_result($rez,$i,"nickname");
			$sweet=mysql_result($rez,$i,"sweet");
			$comments=mysql_result($rez,$i,"comments");
			$id=mysql_result($rez,$i,"id");
			$player=mysql_result($rez,$i,"player");
			$email=mysql_result($rez,$i,"email");
			echo "<tr>\n";
			echo "<td>&nbsp;$nickname</td>\n";
			echo "<td>&nbsp;$last_name</td>\n";
			echo "<td>&nbsp;$first_name</td>\n";
			echo "<td>&nbsp;$city</td>\n";
			echo "<td>&nbsp;$country</td>\n";
			echo "<td>&nbsp;$age</td>\n";
			echo "<td>&nbsp;".($sweet==1?"yes":"no")."</td>\n";
			echo "<td>&nbsp;".($player==1?"yes":"no")."</td>\n";
			echo "<td>&nbsp;$email</td>\n";
			echo "<td>&nbsp;$comments</td>\n";
			echo "<td><a href=\"edit_user?user_id=".$id."\"> Edit
				</a></td>";
			echo "<td><a href=\"javascript:del('delete_user.php?log_id=".$id."')\"> Delete </a></td>";

			echo "</tr>\n";

			++$i;
		}
		echo "</table><br>\n";
	}
	else {
		echo "No records found, sorry!<br>";
}
}
else {
$query="SELECT id,username,last_name,email,first_name,age,nickname,country,city,player,comments FROM users WHERE id=\"$user_id\" ";
$rez=mysql_query($query) or mysql_die();

    $username=mysql_result($rez,$i,"username");
    $last_name=mysql_result($rez,$i,"last_name");
    $first_name=mysql_result($rez,$i,"first_name");
    $age=mysql_result($rez,$i,"age");
    $country=mysql_result($rez,$i,"country");
    $city=mysql_result($rez,$i,"city");
    $nickname=mysql_result($rez,$i,"nickname");
    $comments=mysql_result($rez,$i,"comments");
    $id=mysql_result($rez,$i,"id");
    $player=mysql_result($rez,$i,"player");
    $email=mysql_result($rez,$i,"email");
?>


<form name="form1" method="post" action="submit_user_changes.php">
  <table width=60%  border="1" cellspacing="0" cellpadding="4">
<tr>
      <td align="left" valign="top">Username</td>
      <td><input name="username" type="text" id="username" value="<? echo $username; ?>"></td>
    </tr>
    <tr>
      <td align="left" valign="top">First Name</td>
      <td><input name="first_name" type="text" id="first_name" value="<? echo $first_name; ?>"></td>
    </tr>

    <tr>
      <td valign="top">Last Name</td>
      <td><input name="last_name" type="text" id="last_name" value="<? echo $last_name; ?>"></td>
    </tr>
    <tr>
      <td valign="top">Age</td>
      <td><input name="age" type="text" id="age" value="<? echo $age; ?>"></td>
    </tr>
    <tr>
      <td valign="top">Nickname</td>

      <td><input name="nickname" type="text" id="nickname" value="<? echo $nickname; ?>"></td>
    </tr>

<input name="id" type="hidden"  value="<? echo $id; ?>">
    <tr>
      <td valign="top">City</td>

      <td><input name="city" type="text" id="city" value="<? echo $city; ?>"></td>
    </tr>
    <tr>
      <td valign="top">Country</td>

      <td><input name="country" type="text" id="country" value="<? echo $country; ?>"></td>
    </tr>
    <tr>
      <td valign="top">E-mail address</td>

      <td><input name="email" type="text" id="email" size=60 value="<? echo $email; ?>"></td>
    </tr>
    <tr>
      <td valign="top">Player</td>

      <td><input name="player" type="text" id="player" value="<? echo $player; ?>"></td>
    </tr>
 
    <tr>
      <td valign="top">Comments</td>
      <td><textarea name="comments" id="comments"><? echo $comments; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><input type="button" value="Cancel changes" onClick="javascript:history.back()">&nbsp;&nbsp;<input type="submit" name="Submit" value="Submit changes"></td>

    </tr>
  </table>
</form>
<?php

echo "<font size=1><a href=\"javascript:openwin('change_password_user_adm.php?login_id=".$user_id."',350,210)\">Change  password</a></font>";
}
require 'footer.php';
?>
