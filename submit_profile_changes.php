<?php
require 'conf.php';
require 'config/config_foot.php';
require 'auth_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
// Define post fields into simple variables
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$nickname = $_POST['nickname'];
$country = $_POST['country'];
$comments = $_POST['comments'];
$city = $_POST['city'];
$age = $_POST['age'];
$profile_edited=1;
$fav_team=$_POST['fav_team'];
$fav_player=$_POST['fav_player'];
$user_language=$_POST['user_language'];
/* Let's strip some slashes in case the user entered
any escaped characters. */

/*$first_name = stripslashes($first_name);
$last_name = stripslashes($last_name);
$nickname = addslashes($nickname);
$country = stripslashes($country);
$comments = addslashes($comments);
$city = addslashes($city);
$age = stripslashes($age);
$fav_player=addslashes($fav_player);
*/

/*if((!$first_name) || (!$last_name) || (!$city)){
    echo 'You did not submit the following required information! <br />';
    if(!$first_name){
        echo "First Name is a required field. Please enter it below.<br />";
    }
    if(!$last_name){
        echo "Last Name is a required field. Please enter it below.<br />";
    }
    if(!$email){
        echo "Email Address is a required field. Please enter it below.<br />";
    }
    if(!$city){
        echo "City is a required field. Please enter it below.<br />";
    }
    echo "<a href=edit_profile.php>back</a>\n";
    // End the error checking and if everything is ok, we'll move on to creating the user account
    exit(); // if the error checking has failed, we'll exit the script!
}*/
    
 
// Enter info into the Database.
connect_to_eurodb();
 mysqli_query($link,"SET NAMES 'utf8'");

$query="UPDATE users SET first_name=\"$first_name\", last_name=\"$last_name\", nickname=\"$nickname\", city=\"$city\", country=\"$country\", age=\"$age\",comments=\"$comments\",fav_team=\"$fav_team\",fav_player=\"$fav_player\", profile_edited=\"$profile_edited\",language='$user_language',last_login=\"now()\"  WHERE id=\"$login_id\"";

//echo "query: $query <br>\n";
$sql = mysqli_query($link,$query) or die(mysql_error());
if(!$sql){
    echo "There has been an error updating the changes. Please contact the webmaster.ID: ".$login_id;
} else {
	$res=mysqli_query($link,"select player from users where id=\"$login_id\"") or die(mysql_error());
	$player=mysqli_result($res,0,0);
	set_language($user_language);
	//echo $_SESSION['language'];
	session_write_close();
	session_start();
	if ($player) header("location:index.php");
	else header("location:index.php"); 
}
?>
<?php
require 'foot_foot.php';
?>
