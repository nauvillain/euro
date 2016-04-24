<?php
require 'lib_foot.php';
require 'config/config_foot.php';
require 'session_language.php';
//languages are defined in the language array in conf.php; 
//the language table must have the same languages
// Define post fields into simple variables
$id=$_POST['id'];
$word=get_words();
connect_to_eurodb();
sqlutf();
//print_r($language);
//break;
$str="";
for($i=0;$i<sizeof($language_array);$i++){	
	$str.=($i==0?"":",")."word_".$language_array[$i]."=\"".$word[$i]."\"";
	}

if(!$id){
	// construct the list of language fields, like word_fr,word_en...
	$query="INSERT INTO language SET ".$str;
//	echo $query;
	$sql = mysql_query($query) or die(mysql_error());
}
else {
	
	$query="UPDATE language SET ".$str." WHERE language.id=$id";
 	$re=mysql_query($query);	
	if($re) {
			header("location:list_translations.php");
			exit;
	}
}

if(!$sql){
		require 'head.php';
		require 'header_recipe.php';
		echo 'There has been an error updating the changes. Please contact the webmaster. '.$query."hu:$match_hu , en:$match_en; fr: $match_fr";
		}
else {
	header("location:list_translations.php");
	exit;
}

?>

