<?php
require 'authAdm.php';
require 'lib.php';
require 'headerAdm.php';
require 'javascript.php';
echo "<TITLE>Admin - Submit Changes - Euro 2004</TITLE>";
// Define post fields into simple variables
$id=$_POST['id'];
$username = $_POST['username'];
$password = $_POST['password'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$age = $_POST['age'];
$nickname= $_POST['nickname'];
$fav_player = $_POST['fav_player'];
$fav_team = $_POST['fav_team'];
$country = $_POST['country'];
$comments = $_POST['comments'];
$city= $_POST['city'];

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
$query="UPDATE players SET
username=\"$username\",password=password(\"$password\"),first_name=\"$first_name\",
last_name=\"$last_name\", age=\"$age\", city=\"$city\",
country=\"$country\", nickname=\"$nickname\", fav_player=\"$fav_player\", fav_team=\"$fav_team\", comments=\"$comments\"  WHERE id=\"$id\" ";

//echo "query: $query <br>\n";
$sql = mysql_query($query);
if(!$sql){
    echo 'There has been an error updating the changes. Please contact
    the webmaster.';
} else {
   echo "<p><b>Your changes have been saved.</b></p>";
 }

?>
<?php
require 'footer.php';
?>