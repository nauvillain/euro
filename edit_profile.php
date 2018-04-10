<?php
require 'php_header.php';
require 'javascript.php';
require 'javascript_form.php';
//require 'auth_guest.php';

echo "<div id='foot_main'>";
connect_to_eurodb();
$result=mysqli_query($link,"SELECT * FROM users  WHERE id='$login_id'") or die(mysql_error());
if(!mysqli_num_rows($result)){
    echo "Strange error: there is no user with this id anymore. Maybe you were deleted from the database\n";
    require 'foot_foot.php';
    exit;
}
//$row=mysql_fetch_array($result);
$first_name=mysqli_result($result,0,"first_name");
$last_name=mysqli_result($result,0,"last_name");
$nickname=mysqli_result($result,0,"nickname");
$country=mysqli_result($result,0,"country");
$city=mysqli_result($result,0,"city");
$comments=mysqli_result($result,0,"comments");
$age=mysqli_result($result,0,"age");
$fav_player=mysqli_result($result,0,"fav_player");
$fav_team=mysqli_result($result,0,"fav_team");
$user_language=mysqli_result($result,0,"language");

?>
<div style='margin:25px';>
<h2><?php get_word_by_id(110);?></h2>

<form name="form1" method="post" action="submit_profile_changes.php"
  onsubmit='javascript:return validateFormUser(this)'>
  <table width="60%" border="0" cellspacing="0" cellpadding="4">
    <tr> 
      <td valign="top"><?php echo get_word_by_id(111);?></td>
      <td><input name="first_name" type="text" id="first_name" value="<?php echo $first_name; ?>"></td>
    </tr>

    <tr> 
      <td valign="top"><?php echo get_word_by_id(112);?></td>
      <td><input name="last_name" type="text" id="last_name" value="<?php echo $last_name; ?>"></td>
    </tr>
    <tr> 
      <td valign="top"><?php echo get_word_by_id(113);?></td>
      <td><input name="nickname" type="text" id="nickname" size=50 value="<?php echo $nickname; ?>"></td>
    </tr>
    <tr> 
      <td valign="top"><?php echo get_word_by_id(114);?></td>

      <td><input name="age" type="text" id="age" value="<?php echo $age; ?>"></td>
    </tr>

    <tr> 
      <td valign="top"><?php echo get_word_by_id(115);?></td>

      <td><input name="city" type="text" id="city" value="<?php echo $city; ?>"></td>
    </tr>
    <tr> 
      <td valign="top"><?php echo get_word_by_id(116);?></td>

      <td><input name="fav_player" type="text" id="fav_player" size=60 value="<?php echo $fav_player; ?>"></td>
    </tr>
    <tr> 
      <td valign="top"><?php echo get_word_by_id(117);?></td>


      <td><input name="fav_team" type="text" id="fav_team" value="<?php echo $fav_team; ?>"></td
    </tr>
    <tr> 
      <td valign="top"><?php echo get_word_by_id(118);?></td>


      <td><input name="country" type="text" id="country" value="<?php echo $country; ?>"></td>
    </tr>
    <tr>
      <td valign="top"><?php echo get_word_by_id(119);?></td>
      <td><select name='user_language'><?php
	for($i=0;$i<sizeof($language_array);$i++){
		$lan=$language_array[$i];
		echo "<option value='$lan'".($user_language==$lan?" selected":"").">$lan</option>\n";

	} ?>

	</select>
	</td>
    </tr>
    <tr> 
      <td valign="top"><?php echo get_word_by_id(120);?></td>

      <td><textarea name="comments" id="comments"><?php echo $comments; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top">&nbsp;</td>
      <td><input type="button" value="<?php echo get_word_by_id(122);?>" onClick="javascript:history.back()">&nbsp;&nbsp;&nbsp;<input type="submit" name="Submit" value="<?php echo get_word_by_id(121);?>"></td>

    </tr>
  </table>
</form>
<a href="javascript:openwin('change_password.php',350,210)"><?php echo get_word_by_id(123);?></a><br>
			<a href='upload_image.php'>Upload your profile picture</a>;
</div>
</div>









