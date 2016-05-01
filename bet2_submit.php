<?php
require 'auth/auth.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';

$id=$_POST['match_id'];
$pick=$_POST['pick'];
$weight=$_POST['weight'];
$res=still_time($id);

if($res!=0){

	$query="SELECT * FROM bets WHERE match_id='$id' AND player_id='$login_id'";
	//echo $query."<br>";
	$sql=mysql_query($query) or die(mysql_error());
	$tot=mysql_num_rows($sql);
	if(!$tot){
		$query="INSERT INTO bets SET pick='$pick',weight='$weight', match_id='$id',player_id='$login_id'";
		//echo $query."<br>";
		$sql=mysql_query($query) or die(mysql_error());
	}

	else{
		$query="UPDATE bets SET pick='$pick',weight='$weight' WHERE match_id='$id' AND player_id='$login_id'";
		$sql=mysql_query($query) or die(mysql_error());
	}
	if(!$sql){
		echo 'There has been an error updating the changes. Please contact the webmaster.';
	}
	else {
		$arr=odds($id);
		$query="UPDATE matches SET odds1=".($arr[0]).",oddsD=".($arr[1]).",odds2=".($arr[2])." WHERE id=$id";
		$re=mysql_query($query);
		header('location:index.php');	
	}
}



else {
	echo "You submitted your bet too late! Sorry.";
	}
?>
