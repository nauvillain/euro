<?php
require 'auth.php';
require 'head.php';
require 'header.php';
require 'lib.php';
require 'javascript.php';
echo "<TITLE>Submit Changes - Euro 2004</TITLE>";
// Define post fields into simple variables
$money = $_POST['checkbox'];


if(!$money) $money=0;
    
 
// Enter info into the Database.
connect_to_database();
$query="UPDATE users SET bet_money=$money WHERE id=\"$login_id\"";

//echo "query: $query <br>\n";
$sql = mysql_query($query);
if(!$sql){
    echo 'There has been an error updating the changes. Please contact the webmaster.';
} else {
	header("location:index.php"); 
}
?>
<?php
?>
