<?php
require 'auth.php';
require 'lib_gen.php';
require 'lib_foot.php';
// Define post fields into simple variables
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$username=$_POST['username'];
$password=$_POST['pass'];

/* Let's strip some slashes in case the user entered
any escaped characters. */

$first_name = stripslashes($first_name);
$last_name = stripslashes($last_name);
/* Do some error checking on the form posted fields */

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
$query="INSERT INTO users SET first_name=\"$first_name\", last_name=\"$last_name\",username=\"$last_name\",password=password(\"$password\"), last_login=\"now()\"  WHERE id=\"$login_id\"";

//echo "query: $query <br>\n";
$sql = mysql_query($query) or die(mysql_error());
if(!$sql){
    echo "There has been an error updating the changes. Please contact the webmaster.ID: ".$login_id;
} else {
	$res=mysql_query("select player from users where id=\"$login_id\"") or die(mysql_error());
	$player=mysql_result($res,0,0);
	if ($player) header("location:index.php");
	else header("location:index.php"); 
}
?>
<?php
require 'foot_foot.php';
?>
