<?php
require 'auth.php';
require 'lib.php';
require 'javascript.php';
require 'head.php';
require 'header.php';

connect_to_database();

//gather info about the user

$result=mysql_query("SELECT first_name, nickname, bets_phase1,
bets_phase2,profile_edited, top_scorer,username FROM users WHERE id='$login_id'") or mysql_die();
if(!mysql_num_rows($result)){
    echo "Strange error: there is no user with this id anymore. Maybe you were deleted from the database\n";
    require 'footer.php';
    exit;
}
$first_name=mysql_result($result,0,'first_name');
$bets_phase1=mysql_result($result,0,'bets_phase1');
$bets_phase2=mysql_result($result,0,'bets_phase2');
$profile_edited=mysql_result($result,0,'profile_edited');
$top_scorer=mysql_result($result,0,'top_scorer');
$username=mysql_result($result,0,'username');

if(!$first_name) $first_name=mysql_result($result,0,'nickname');
echo "<p class='greeting'><font size=1> Welcome,".$first_name."</font></p>\n";
mysql_free_result($result);


if(($profile_edited==0)&&($username!='guest')) echo "<p align=left><a
href='edit_profile.php'>Please tell us a few things about yourself</a></p>\n";


echo "<p class='menu_center'><h2>Welcome to our site!</h2></p>\n";


require 'footer.php';
?>
