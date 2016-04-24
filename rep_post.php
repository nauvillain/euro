<?php
require 'auth.php';
require 'lib.php';
require 'javascript.php';

echo "<TITLE>New post - Euro 2004</TITLE>";

// Define post fields into simple variables
$content = $_POST['content'];
$thread	 = $_POST['thread'];
$title = $_POST['title'];


/* Let's strip some slashes in case the user entered
any escaped characters. */

$title = addslashes($title);
$content = addslashes($content);


// Enter info into the Database.
connect_to_database();
if(!$title) $query="INSERT INTO forum SET thread='$thread',
content=\"$content\",player_id='$login_id', date='CURDATE',time='CURTIME()'";
else  $query="INSERT INTO forum SET title=\"$title\",
content=\"$content\",player_id='$login_id', date='CURDATE()',time='CURTIME()'";
//echo "query: $query <br>\n";
$sql = mysql_query($query) or mysql_die();
if(!$sql){
    echo 'There has been an error updating the changes. Please contact the webmaster.';
} else {
   echo "<br><br><br><table width=100% height=300><tr><td><b>Your message has been posted. It should show very soon on
   the forum.</b>";
   echo "<br><a href='#' onClick='window.close()'>Close</a></td></tr></table>";
 }
?>
<?php
require 'footer.php';
?>
