<?php

require 'authAdm.php';
require 'lib.php';

$id=$_REQUEST['log_id'];


connect_to_database();

$query="DELETE FROM users WHERE id=\"$id\" " ;
$sql = mysql_query($query);
if(!$sql){
    echo 'There has been an error updating the changes. Please contact
    the webmaster.';
} else {
  header("Location:edit_user.php");
}

?><?php
require 'footer.php';
?>
