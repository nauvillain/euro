<?php

require 'authAdm.php';
require 'lib.php';

$id=$_REQUEST['id'];


connect_to_database();

$query="DELETE FROM forum WHERE id=\"$id\" " ;
$sql = mysql_query($query);
if(!$sql){
    echo 'There has been an error updating the changes. Please contact
    the webmaster.';
} else header("Location:message_deleted.php");

require 'footer.php';
?>