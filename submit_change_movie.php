<?php
require 'auth.php';
require 'lib.php';
require 'head.php';
require 'header_movie.php';
require 'javascript.php';
// Define post fields into simple variables
$id=$_POST['id'];
$movie_title = $_POST['movie_title'];
$sub = $_POST['sub'];
$media_id = $_POST['media_id'];
/* Do some error checking on the form posted fields */

    if(!$movie_title){
        echo "The Movie Title is a required field.<br>\n";
	echo "<a href='javascript:history.back()>Go back to the form</a>";
	exit();
    }
    if(!$media_id){
	    echo "Media ID is a required field.<br>\n";
	    echo "<a href='javascript:history.back()>Go back to the form</a>";
	    exit();
				        }
					
   
   
// Enter info into the Database.
connect_to_database();
$query="UPDATE movies SET
movie_title=\"$movie_title\",sub=\"$sub\",
media_id=\"$media_id\" WHERE id=\"$id\" ";

//echo "query: $query <br>\n";
$sql = mysql_query($query);
if(!$sql){
    echo 'There has been an error updating the changes. Please contact
    the webmaster.';
} else {
   	header("location:list_movies.php?manage=yes");
	//echo "<p><b>Your changes have been saved.</b></p>";
 }

?>
<?php
require 'footer.php';
?>
