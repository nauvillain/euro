<?php
require 'authAdm.php';
require 'lib.php';
require 'head.php';
require 'headerAdm.php';
require 'javascript.php';
echo "<TITLE>Admin - Submit Changes - Euro 2004</TITLE>";
// Define post fields into simple variables
$id=$_POST['id'];
$username = $_POST['username'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$nickname= $_POST['nickname'];
$country = $_POST['country'];
$comments = $_POST['comments'];
$city= $_POST['city'];
$email=$_POST['email'];
$player=$_POST['player'];
/* Do some error checking on the form posted fields */

if(!$username){
    echo 'You did not submit the following required information! <br />';
    if(!$username){
        echo "Username is a required field.<br>\n";
	echo "<a href='javascript:history.back()>Go back to the form</a>";
    }
   
   
//    include 'editRecordAdm.php'; // Show the form again!
    /* End the error checking and if everything is ok, we'll move on to
     creating the user account */
    exit(); // if the error checking has failed, we'll exit the script!
}
    
 
// Enter info into the Database.
connect_to_database();
$query="UPDATE users SET
username=\"$username\",first_name=\"$first_name\",
last_name=\"$last_name\",email=\"$email\", age=\"$age\", city=\"$city\",
country=\"$country\", player='$player',nickname=\"$nickname\", comments=\"$comments\"  WHERE id=\"$id\" ";

//echo "query: $query <br>\n";
$sql = mysql_query($query);
if(!$sql){
    echo 'There has been an error updating the changes. Please contact
    the webmaster.';
} else {
   header("location:edit_user.php");
 }

?>
<?php
require 'footer.php';
?>
