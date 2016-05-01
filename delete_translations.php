<?php
require 'lib_foot.php';
require 'session_language.php';
//languages are defined in the language array in conf.php; 
//the language table must have the same languages
// Define post fields into simple variables
$id=$_REQUEST['word_id'];
connect_to_eurodb();
//print_r($language);
//break;

if($id){
	$query="DELETE FROM language WHERE id='$id'";
//	echo $query;
	$sql = mysql_query($query) or die(mysql_error());
	header("location:list_translations.php");
	exit;
}

?>

