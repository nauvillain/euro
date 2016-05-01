<?php
require 'authAdm.php';
require 'lib.php';
require 'headerAdm.php';
require 'javascript.php';

echo "<TITLE>Admin - Edit records - Euro 2004</TITLE>";

$id=$_REQUEST['login_id'];

connect_to_database();
$query="SELECT id,username,last_name,first_name,age,nickname,country,city,fav_player,fav_team,comments FROM players WHERE id=\"$id\" ";
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
    $fav_player=mysql_result($rez,$i,"fav_player");
    $fav_team=mysql_result($rez,$i,"fav_team");
    
?>


<form name="form1" method="post" action="submitChangesAdm.php">
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
    </tr
    <tr> 
<td valign="top">Favorite Player</td>

      <td><input name="fav_player" type="text" id="fav_player" value="<? echo $fav_player; ?>"></td>
    </tr>
<td valign="top">Favorite Team</td>

      <td><input name="fav_team" type="text" id="fav_team" value="<? echo $fav_team; ?>"></td>
    </tr>
    <tr>
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
echo "<font size=1><a href=\"javascript:openwin('change_passwordPlayerAdm.php?login_id=".$login_id."',350,210)\">Change  password</a></font>";
?>
<?php
require 'footer.php';
?>