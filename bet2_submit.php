<?php
require 'auth/auth.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';

$id=getIfSet($_POST['match_id']);
$pick=getIfSet($_POST['pick']);
$weight=getIfSet($_POST['weight']);
$res=still_time($id);

if($res!=0){

	$query="SELECT * FROM bets WHERE match_id='$id' AND player_id='$login_id'";
	//echo $query."<br>";
	$sql=mysqli_query($link,$query) or mysqli_error($link);
	$tot=mysqli_num_rows($sql);
	if(!$tot){
		$query="INSERT INTO bets SET pick='$pick',".($weight?"weight='$weight',":"")."match_id='$id',player_id='$login_id'";
		//echo $query."<br>";
		$sql=mysqli_query($link,$query) or die(mysqli_error($link));
	}

	else{
		$query="UPDATE bets SET pick='$pick',weight='$weight' WHERE match_id='$id' AND player_id='$login_id'";
		$sql=mysqli_query($link,$query) or mysqli_error($link);
	}
	$arr=odds($id);
	$query="UPDATE matches SET odds1=".($arr[0]).",oddsD=".($arr[1]).",odds2=".($arr[2])." WHERE id=$id";
	$re=mysqli_query($link,$query);
	header('location:index.php');	
	
}



else {
	echo "You submitted your bet too late! Sorry.";
	}
?>
